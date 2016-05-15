<?php

namespace sndsgd;

class FormTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        new \sndsgd\Form();
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructorException()
    {
        new \sndsgd\Form("names-are-not-allowed");
    }
}
