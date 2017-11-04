<?php

namespace sndsgd\form\field;

class ArrayFieldTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @todo this should go in ParentFieldAbstractTest
     */
    public function testGetValueField()
    {
        $valueField = new ValueField();
        $field = new ArrayField("test", $valueField);
        $this->assertSame($valueField, $field->getValueField());
    }

    /**
     * @dataProvider provideIsOneOrMore
     */
    public function testIsOneOrMore(bool $value)
    {
        $field = new ArrayField("test", new ValueField(), $value);
        $this->assertSame($value, $field->isOneOrMore());
    }

    public function provideIsOneOrMore(): array
    {
        return [
            [false],
            [true],
        ];
    }

    /**
     * @dataProvider providerSetDefaultValue
     */
    public function testSetDefaultValue($value, string $exception)
    {
        if ($exception) {
            $this->setExpectedException($exception);
        }

        $field = new ArrayField("test", new ValueField());
        $field->setDefaultValue($value);
    }

    public function providerSetDefaultValue()
    {
        return [
            [[1, 2, 3], ""],
            [1, \InvalidArgumentException::class],
            ["test", \InvalidArgumentException::class],
            [new \StdClass(), \InvalidArgumentException::class],
        ];
    }

    /**
     * @dataProvider providerSetValueField
     */
    public function testSetValueField($valueField, $exception = "")
    {
        if ($exception) {
            $this->setExpectedException($exception);
        }

        $field = new ArrayField("test", $valueField);
    }

    public function providerSetValueField()
    {
        return [
            [new ArrayField("test", new ValueField()), \InvalidArgumentException::class],
            [new ValueField("test"), ""],
            [new MapField("test", new ValueField(), new ValueField()), ""],
            [new ObjectField("test"), ""],
        ];
    }

    /**
     * @dataProvider providerValidate
     */
    public function testValidate($field, $values, $errorCount, $expect)
    {
        $form = new \sndsgd\Form();
        $validator = new \sndsgd\form\Validator($form);
        $result = $field->validate($values, $validator);

        $errors = $validator->getErrors();
        $this->assertCount($errorCount, $errors);

        $this->assertSame($expect, $result);
    }

    public function providerValidate()
    {
        $valueField = (new ValueField("test-value"))
            ->addRules(new \sndsgd\form\rule\FloatRule());

        $field = (new ArrayField("test", $valueField))
            ->addRules(new \sndsgd\form\rule\MaxValueCountRule(2));

        return [
            # fail: expecting an array of values
            [
                $field,
                42,
                1,
                [],
            ],

            # fail: one of multiple values fails to validate
            [
                $field,
                [4.2, "abc"],
                1,
                [4.2],
            ],

            # fail: too many values
            [
                $field,
                [1, 2, 3],
                1,
                [],
            ],

            # pass: not required and no values
            [
                $field,
                [],
                0,
                [],
            ],

            # pass: multiple values
            [
                $field,
                ["4.2", 4.2],
                0,
                [4.2, 4.2],
            ],
        ];
    }

    /**
     * @dataProvider provideValidateOneOrMore
     */
    public function testValidateOneOrMore($valueField, $values, $expect)
    {
        $field = new ArrayField("", $valueField, true);
        $form = new \sndsgd\Form();
        $validator = new \sndsgd\form\Validator($form);
        $this->assertSame($expect, $field->validate($values, $validator));
    }

    public function provideValidateOneOrMore(): array
    {
        return [
            [new ValueField(), 1, [1]],
            [new ValueField(), [1, 2], [1, 2]],
            [new ValueField(), "abc", ["abc"]],
            [new ValueField(), ["abc", 42], ["abc", 42]],
        ];
    }

    public function testGetDetail()
    {
        $field = new ArrayField("test", new ValueField());
        $this->assertInstanceOf(
            \sndsgd\form\detail\DetailInterface::class,
            $field->getDetail()
        );
    }
}
