<?php

namespace sndsgd\form\field;

class IntegerFieldTest extends \PHPUnit_Framework_TestCase
{
    public function testGetType()
    {
        $field = new IntegerField("test");
        $this->assertSame("integer", $field->getType());
    }
}
