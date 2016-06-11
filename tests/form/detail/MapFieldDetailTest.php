<?php

namespace sndsgd\form\detail;

use \sndsgd\form\field;

class MapFieldDetailTest extends \PHPUnit_Framework_TestCase
{
    public function testGetType()
    {
        $keyField = new field\ValueField();
        $valueField = new field\ValueField();
        $field = new field\MapField("test", $keyField, $valueField);

        $detail = new MapFieldDetail($field);
        $this->assertSame("map", $detail->getType());
    }
}
