<?php

namespace sndsgd\form\detail;

use \sndsgd\form\field;

class ObjectFieldDetailTest extends \PHPUnit_Framework_TestCase
{
    public function testGetType()
    {
        $field = new field\ObjectField("test");
        $detail = new ObjectFieldDetail($field);
        $this->assertSame("object", $detail->getType());
    }

    /**
     * @dataProvider providerGetSignature
     */
    public function testGetSignature(array $types, $expect)
    {
        $field = new field\ObjectField("test");
        for ($i = 0, $len = count($types); $i < $len; $i++) {
            $mockField = $this->getMockBuilder(field\ValueField::class)
                ->setConstructorArgs(["test$i"])
                ->setMethods(["getDetail"])
                ->getMock();

            $mockDetail = $this->getMockBuilder(ValueFieldDetail::class)
                ->setConstructorArgs([$mockField])
                ->setMethods(["getType"])
                ->getMock();

            $mockField->method("getDetail")->willReturn($mockDetail);
            $mockDetail->method("getType")->willReturn($types[$i]);

            $field->addFields($mockField);
        }

        $detail = new ObjectFieldDetail($field);
        $this->assertSame($expect, $detail->getSignature());
    }

    public function providerGetSignature()
    {
        return [
            [
                ["string", "int", "bool", "string"],
                "object<string,string|int|bool>",
            ]
        ];
    }

    /**
     * @dataProvider providerToArray
     */
    public function testToArray(array $toArrayResults)
    {
        $field = new field\ObjectField("test");
        for ($i = 0, $len = count($toArrayResults); $i < $len; $i++) {
            $mockField = $this->getMockBuilder(field\ValueField::class)
                ->setConstructorArgs(["test$i"])
                ->setMethods(["getDetail"])
                ->getMock();

            $mockDetail = $this->getMockBuilder(ValueFieldDetail::class)
                ->setConstructorArgs([$mockField])
                ->setMethods(["toArray"])
                ->getMock();

            $mockField->method("getDetail")->willReturn($mockDetail);
            $mockDetail->method("toArray")->willReturn($toArrayResults[$i]);

            $field->addFields($mockField);
        }

        $detail = new ObjectFieldDetail($field);
        $this->assertSame($toArrayResults, $detail->toArray()["fields"]);
    }

    public function providerToArray()
    {
        return [
            [
                [["one"], ["two"]],
            ]
        ];
    }

    public function testGetRules()
    {
        $field = new field\ObjectField("test");
        $detail = new ObjectFieldDetail($field);
        $this->assertSame([], $detail->getFieldRules());
        $this->assertSame([], $detail->getKeyRules());
        $this->assertSame([], $detail->getValueRules());
    }
}
