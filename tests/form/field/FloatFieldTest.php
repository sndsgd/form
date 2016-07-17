<?php

namespace sndsgd\form\field;

class FloatFieldTest extends \PHPUnit_Framework_TestCase
{
    public function testGetType()
    {
        $field = new FloatField("test");
        $this->assertSame("float", $field->getType());
    }
}
