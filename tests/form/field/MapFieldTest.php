<?php

namespace sndsgd\form\field;

class MapFieldTest extends \PHPUnit_Framework_TestCase
{
    public function testGetKeyField()
    {
        $keyField = new ValueField("key");
        $valueField = new ValueField("value");
        $field = new MapField("", $keyField, $valueField);
        $this->assertSame($keyField, $field->getKeyField());
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
        $keyField = (new ValueField("test-key"))
            ->addRules(new \sndsgd\form\rule\AlphaNumRule());

        $valueField = (new ValueField("test-value"))
            ->addRules(new \sndsgd\form\rule\FloatRule());

        $field = new MapField("test", $keyField, $valueField);

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

    public function testGetDetail()
    {


        $field = new MapField("test", new ValueField(), new ValueField());
        $this->assertInstanceOf(
            \sndsgd\form\detail\DetailInterface::class,
            $field->getDetail()
        );
    }
}
