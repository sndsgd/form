<?php

namespace sndsgd\form\rule;

class FloatRuleTest extends \PHPUnit_Framework_TestCase
{
    public function testGetDescription()
    {
        $rule = new FloatRule();
        $this->assertSame("type:float", $rule->getDescription());
    }

    /**
     * @dataProvider providerGetErrorMessage
     */
    public function testGetErrorMessage($customMessage, $expect)
    {
        $rule = new FloatRule();
        if ($customMessage) {
            $rule->setErrorMessage($customMessage);
        }
        $this->assertEquals($expect, $rule->getErrorMessage());
    }

    public function providerGetErrorMessage()
    {
        return [
            ["", "must be a float"],
            ["custom error message", "custom error message"],
        ];
    }

    /**
     * @dataProvider providerValidate
     */
    public function testValidate($test, $expect, $newValue = null)
    {
        $rule = new FloatRule();
        $this->assertSame($expect, $rule->validate($test));
        if ($newValue !== null) {
            $this->assertSame($newValue, $test);
        }
    }

    public function providerValidate()
    {
        return [
            [-1, true],
            [0, true],
            [1, true],
            [PHP_INT_MAX, true],
            [2.4, true],
            ["4.2", true, 4.2],
            ["asd", false],
            [new \StdClass(), false],
        ];
    }
}
