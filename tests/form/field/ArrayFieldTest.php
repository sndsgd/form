<?php

namespace sndsgd\form\field;

class ArrayFieldTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerSetValueField
     */
    public function testSetValueField($valueField, $exception = "")
    {
        if ($exception) {
            $this->setExpectedException($exception);
        }

        $field = new ArrayField("test");
        $field->setValueField($valueField);
    }

    public function providerSetValueField()
    {
        return [
            [new ArrayField("test"), \InvalidArgumentException::class],
            [new ScalarField("test"), ""],
            [new MapField("test"), ""],
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
        $field = (new ArrayField("test"))
            ->addRules(new \sndsgd\form\rule\MaxValueCountRule(2))
            ->setValueField(
                (new ScalarField("test-value"))
                    ->addRules(new \sndsgd\form\rule\FloatRule())
            );

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
}
