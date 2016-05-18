<?php

namespace sndsgd\form\field;

class MapFieldTest extends \PHPUnit_Framework_TestCase
{
    public function testSetKeyField()
    {
        $field = new MapField("test");
        $field->setKeyField(new ValueField("test-key"));
    }

    public function testSetValueField()
    {
        $field = new MapField("test");
        $field->setValueField(new MapField("test-value"));
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
        $field = (new MapField("test"))
            ->setKeyField(
                (new ValueField("test-key"))
                    ->addRules(new \sndsgd\form\rule\AlphaNumRule())
            )
            ->setValueField(
                (new ValueField("test-value"))
                    ->addRules(new \sndsgd\form\rule\FloatRule())
            );

        return [
            # fail: expecting a map of values
            [
                $field,
                42,
                1,
                [],
            ],

            # fail: key validation fails
            [
                $field,
                ["!@#$%^&*()" => 4.2],
                1,
                [],
            ],

            # fail: value validation fails
            [
                $field,
                ["test" => "abc"],
                1,
                [],
            ],

            # pass: a map with a single value
            [
                $field,
                ["test" => "4.2"],
                0,
                ["test" => 4.2],
            ],

            # pass: a map with multiple values
            [
                $field,
                [
                    "one" => 1,
                    "two" => 2,
                ],
                0,
                [
                    "one" => 1.0,
                    "two" => 2.0,
                ],
            ],
        ];
    }
}
