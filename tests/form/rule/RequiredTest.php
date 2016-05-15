<?php

namespace sndsgd\form\rule;

class RequiredTest extends \PHPUnit_Framework_TestCase
{
    public function testGetDescription()
    {
        $rule = new RequiredRule();
        $this->assertEquals("required", $rule->getDescription());
    }

    public function testGetErrorMessage()
    {
        $rule = new RequiredRule();
        $this->assertEquals("required", $rule->getErrorMessage());
    }

    /**
     * @dataProvider providerValidate
     */
    public function testValidate($test, $expect)
    {
        $rule = new RequiredRule();
        $this->assertSame($expect, $rule->validate($test));
    }

    public function providerValidate()
    {
        return [
            ["", false],
            [null, false],
            [0, true],
            [-1, true],
            [new \StdClass(), true],
        ];
    }
}
