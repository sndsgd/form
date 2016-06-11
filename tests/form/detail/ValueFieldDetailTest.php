<?php

namespace sndsgd\form\detail;

use \sndsgd\form\field;
use \sndsgd\form\rule;

class ValueFieldDetailTest extends \PHPUnit_Framework_TestCase
{
    private function createField(string $type)
    {
        $field = new field\ValueField("test");
        switch ($type) {
            case "string": return $field;
            case "bool": return $field->addRules(new rule\BooleanRule());
            case "int": return $field->addRules(new rule\IntegerRule());
            case "float": return $field->addRules(new rule\FloatRule());
            case "number": return $field->addRules(new rule\FloatRule());
            default: return $field->setType($type);
        }
    }

    /**
     * @dataProvider providerGetType
     */
    public function testGetType($type)
    {
        $field = $this->createField($type);
        $detail = $field->getDetail();
        $this->assertSame($type, $detail->getType());
        $this->assertSame($type, $detail->getSignature());
    }

    public function providerGetType()
    {
        return [
            ["string"],
            ["bool"],
            ["float"],
            ["int"],
            ["file"],
        ];
    }

    public function testGetRules()
    {
        $field = new field\ValueField("test");
        $detail = $field->getDetail();
        $this->assertSame([], $detail->getFieldRules());
        $this->assertSame([], $detail->getKeyRules());
    }

    /**
     * @dataProvider providerGetValueRules
     */
    // public function testGetValueRules()
    // {

    // }
}
