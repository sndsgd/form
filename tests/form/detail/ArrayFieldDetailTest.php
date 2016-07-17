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
    public function testGetSignature($valueField, $expect)
    {
        $field = new field\ArrayField("test", $valueField);
        $detail = new ArrayFieldDetail($field);
        $this->assertSame($expect, $detail->getSignature());
    }

    public function providerGetSignature()
    {
        return [
            [new field\StringField(), "array<string>"],
            [new field\IntegerField(), "array<integer>"],
            [new field\FloatField(), "array<float>"],
            [new field\BooleanField(), "array<boolean>"],
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
