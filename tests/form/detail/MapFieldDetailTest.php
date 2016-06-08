<?php

namespace sndsgd\form\detail;

class MapFieldDetailTest extends \PHPUnit_Framework_TestCase
{
    public function testGetType()
    {
        $field = (new \sndsgd\form\field\MapField("test"))
            ->setKeyField(new \sndsgd\form\field\ValueField())
            ->setValueField(new \sndsgd\form\field\ValueField());

        $detail = new MapFieldDetail($field);
        $this->assertSame("map", $detail->getType());
    }    
}
