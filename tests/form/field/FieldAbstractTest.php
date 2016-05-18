<?php

namespace sndsgd\form\field;

class AbstractFieldTest extends \PHPUnit_Framework_TestCase
{
    public function setup()
    {
        $this->field = $this->getMockForAbstractClass(FieldAbstract::class);
    }
    /**
     * @dataProvider providerSetGetName
     */
    public function testSetGetName($name, array $parents, $expectParentName)
    {
        $this->field->setName($name);
        $this->assertSame($name, $this->field->getName());

        $this->assertSame($expectParentName, $this->field->getName($parents));
    }

    public function providerSetGetName()
    {
        return [
            ["testname", ["parent"], "parent.testname"],
            ["💩", ["emoji", "💩"], "emoji.💩.💩"],
        ];
    }

    /**
     * @dataProvider providerGetNestedName
     */
    public function testGetNestedName($field, $delimiter, $name, $expect)
    {
        $this->assertSame($expect, $field->getNestedName($delimiter, $name));
    }

    public function providerGetNestedName()
    {
        $one = new \sndsgd\form\field\ObjectField("one");
        $two = new \sndsgd\form\field\ObjectField("two");
        $arr = new \sndsgd\form\field\ArrayField("arr");
        $three = new \sndsgd\form\field\ValueField("three");
        $mapKey = new \sndsgd\form\field\ValueField("mapkey");
        $map = (new \sndsgd\form\field\MapField("map"))
            ->setKeyField($mapKey);

        $form = (new \sndsgd\Form())
            ->addFields(
                $one->addFields(
                    $two->addFields($three),
                    $arr->setValueField($map)
                )
            );

        return [
            [$one, ".", "", "one"],
            [$two, ".", "", "one.two"],
            [$two, "/", "unknown", "one/two/unknown"],
            [$arr, ".", "", "one.arr"],
            [$arr, "|", "0", "one|arr|0"],
            [$three, "💩", "", "one💩two💩three"],
            [$mapKey, ".", "", "one.arr.map.mapkey"],
        ];
    }

    public function testSetGetDescription()
    {
        $description = "test description";
        $this->field->setDescription($description);
        $this->assertSame($description, $this->field->getDescription());
    }

    public function testSetGetParent()
    {
        $parent = $this->getMockForAbstractClass(FieldAbstract::class);
        $this->field->setParent($parent);
        $this->assertSame($parent, $this->field->getParent());
    }

    public function testSetGetDefaultValue()
    {
        $value = 42;
        $this->field->setDefaultValue($value);
        $this->assertSame($value, $this->field->getDefaultValue());
    }

    /**
     * @dataProvider providerRules
     */
    public function testRules(array $rules, $exception = null)
    {
        if ($exception) {
            $this->setExpectedException($exception);
        }

        $rc = new \ReflectionClass($this->field);
        $method = $rc->getMethod("addRules");
        $method->invokeArgs($this->field, $rules);

        foreach ($rules as $rule) {
            $this->assertTrue($this->field->hasRule($rule->getClass()));
        }
    }

    public function providerRules()
    {
        return [
            // duplicate rules
            [
                [
                    new \sndsgd\form\rule\RequiredRule(), 
                    new \sndsgd\form\rule\RequiredRule(),
                ],
                \sndsgd\form\DuplicateRuleException::class,
            ],
            [
                [
                    new \sndsgd\form\rule\IntegerRule(),
                    new \sndsgd\form\rule\RequiredRule(),
                ],
                null,
            ],
        ];
    }

    public function testRequiredRuleFirst()
    {
        $this->field->addRule(new \sndsgd\form\rule\IntegerRule());
        $this->field->addRule(new \sndsgd\form\rule\RequiredRule());
        $this->assertTrue($this->field->hasRule(\sndsgd\form\rule\RequiredRule::class));
        $rules = $this->field->getRules();
        $firstRule = array_shift($rules);
        $this->assertInstanceOf(\sndsgd\form\rule\RequiredRule::class, $firstRule);
    }

    public function testRemoveRules()
    {
        $this->field->addRule(new \sndsgd\form\rule\RequiredRule());
        $this->field->removeRules(\sndsgd\form\rule\RequiredRule::class);
        $this->assertSame(0, count($this->field->getRules()));
    }
}
