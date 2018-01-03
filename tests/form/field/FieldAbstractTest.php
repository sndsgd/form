<?php

namespace sndsgd\form\field;

class FieldAbstractTest extends \PHPUnit_Framework_TestCase
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
        $one = new ObjectField("one");
        $two = new ObjectField("two");
        $three = new ValueField("three");
        $mapKey = new ValueField("mapkey");
        $map = new MapField("map", $mapKey, new ValueField());
        $arr = new ArrayField("arr", $map);

        $form = (new \sndsgd\Form())
            ->addFields(
                $one->addFields(
                    $two->addFields($three),
                    $arr
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
