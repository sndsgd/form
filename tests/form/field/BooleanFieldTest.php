<?php

namespace sndsgd\form\field;

class BooleanFieldTest extends \PHPUnit_Framework_TestCase
{
    public function testGetType()
    {
        $field = new BooleanField("test");
        $this->assertSame("boolean", $field->getType());
    }
}
