<?php

namespace sndsgd\form\field;

class ObjectFieldTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \sndsgd\form\DuplicateFieldException
     */
    public function testAddFieldsException()
    {
        $field = (new ObjectField())
            ->addFields(
                new ScalarField("name"),
                new ScalarField("name")
            );
    }

    /**
     * @dataProvider providerHasField
     */
    public function testHasField($field, $name, $expect)
    {
        $this->assertSame($expect, $field->hasField($name));
    }

    public function providerHasField()
    {
        $field = (new ObjectField())
            ->addFields(new ScalarField("title"));

        return [
            [$field, "title", true],
            [$field, "subject", false],
        ];
    }

    /**
     * @dataProvider providerHasField
     */
    public function testGetField($field, $name, $hasField)
    {
        if (!$hasField) {
            $this->setExpectedException("sndsgd\\form\\UnknownFieldException");
        }

        $result = $field->getField($name);
        $this->assertInstanceOf("sndsgd\\form\\field\\FieldInterface", $result);
        $this->assertSame($name, $result->getName());
    }

    public function testValidateUnknownValues()
    {
        $field = (new ObjectField())
            ->addFields(new ScalarField("name"));

        $validator = new \sndsgd\form\Validator(new \sndsgd\Form());

        $result = $field->validate(['unknown' => 0], $validator);
        $errors = $validator->getErrors();
        $this->assertCount(1, $errors);

    }
}
