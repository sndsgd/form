<?php

namespace sndsgd\form\detail;

use \sndsgd\form\field;

class MapFieldDetailTest extends \PHPUnit_Framework_TestCase
{
    private function createField(
        $keyField = null,
        $valueField = null
    ): field\MapField
    {
        $keyField = $keyField ?? new field\StringField();
        $valueField = $valueField ?? new field\StringField();
        return new field\MapField("test", $keyField, $valueField);
    }

    public function testGetType()
    {
        $field = $this->createField();
        $detail = new MapFieldDetail($field);
        $this->assertSame("map", $detail->getType());
    }

    /**
     * @dataProvider provideGetSignature
     */
    public function testGetSignature($keyField, $valueField, $expect)
    {
        $field = $this->createField($keyField, $valueField);
        $detail = new MapFieldDetail($field);
        $this->assertSame($expect, $detail->getSignature());
    }

    public function provideGetSignature(): array
    {
        $stringField = new field\StringField();
        $integerField = new field\IntegerField();
        $stringArrayField = new field\ArrayField("strings", $stringField);
        $integerArrayField = new field\ArrayField("integers", $integerField);

        return [
            [$stringField, $stringField, "map<string,string>"],
            [$stringField, $integerField, "map<string,integer>"],
            [$stringField, $stringArrayField, "map<string,array<string>>"],
            [$stringField, $integerArrayField, "map<string,array<integer>>"],
            [$integerField, $stringField, "map<integer,string>"],
        ];
    }

    public function testGetFieldRules()
    {
        $field = $this->createField();
        $detail = new MapFieldDetail($field);
        $this->assertSame([], $detail->getFieldRules());
    }

    public function testGetKeyRules()
    {
        $field = $this->createField();
        $detail = new MapFieldDetail($field);
        $this->assertSame([], $detail->getKeyRules());
    }

    public function testGetValueRules()
    {
        $field = $this->createField();
        $detail = new MapFieldDetail($field);
        $this->assertSame([], $detail->getValueRules());
    }
}
