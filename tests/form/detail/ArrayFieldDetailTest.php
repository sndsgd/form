<?php

namespace sndsgd\form\detail;

use \sndsgd\form\field;

class ArrayFieldDetailTest extends \PHPUnit_Framework_TestCase
{
    public function testGetType()
    {
        $valueField = new field\ValueField();
        $field = new field\ArrayField("test", $valueField);
        $detail = new ArrayFieldDetail($field);
        $this->assertSame("array", $detail->getType());
    }

    /**
     * @dataProvider providerGetSignature
     */
    public function testGetSignature($valueField, $isOneOrMore, $expect)
    {
        $field = new field\ArrayField("test", $valueField, $isOneOrMore);
        $detail = new ArrayFieldDetail($field);
        $this->assertSame($expect, $detail->getSignature());
    }

    public function providerGetSignature()
    {
        return [
            [new field\StringField(), false, "array<string>"],
            [new field\IntegerField(), false, "array<integer>"],
            [new field\FloatField(), false, "array<float>"],
            [new field\BooleanField(), false, "array<boolean>"],

            [new field\StringField(), true, "string|array<string>"],
            [new field\IntegerField(), true, "integer|array<integer>"],
            [new field\FloatField(), true, "float|array<float>"],
            [new field\BooleanField(), true, "boolean|array<boolean>"],
        ];
    }

    public function testGetFieldRules()
    {
        $valueField = new field\ValueField();
        $field = new field\ArrayField("test", $valueField);
        $detail = new ArrayFieldDetail($field);
        $this->assertSame([], $detail->getFieldRules());
    }

    public function testGetKeyRules()
    {
        $valueField = new field\ValueField();
        $field = new field\ArrayField("test", $valueField);
        $detail = new ArrayFieldDetail($field);
        $this->assertSame([], $detail->getKeyRules());
    }

    public function testGetValueRules()
    {
        $valueField = new field\ValueField();
        $field = new field\ArrayField("test", $valueField);
        $detail = new ArrayFieldDetail($field);
        $this->assertSame([], $detail->getValueRules());
    }
}
