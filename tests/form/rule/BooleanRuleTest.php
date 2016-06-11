<?php

namespace sndsgd\form\rule;

class BooleanRuleTest extends \PHPUnit_Framework_TestCase
{
    public function testGetClass()
    {
        $rule = new BooleanRule();
        $this->assertSame(BooleanRule::class, $rule->getClass());
    }

    public function testGetDescription()
    {
        $rule = new BooleanRule();
        $this->assertSame("type:boolean", $rule->getDescription());
    }

    /**
     * @dataProvider providerGetErrorMessage
     */
    public function testGetErrorMessage($customMessage, $expect)
    {
        $rule = new BooleanRule();
        if ($customMessage) {
            $rule->setErrorMessage($customMessage);
        }
        $this->assertEquals($expect, $rule->getErrorMessage());
    }

    public function providerGetErrorMessage()
    {
        return [
            ["", "must be a boolean"],
            ["custom error message", "custom error message"],
        ];
    }

    /**
     * @dataProvider providerValidate
     */
    public function testValidate($test, $expect, $newValue = null)
    {
        $rule = new BooleanRule();
        $this->assertSame($expect, $rule->validate($test));
        if ($newValue !== null) {
            $this->assertSame($newValue, $test);
        }
    }

    public function providerValidate()
    {
        return [
            [true, true, true],
            [false, true, false],
            [1, true, true],
            [0, true, false],
            [42, false, 42],
            ["true", true, true],
            ["false", true, false],
            ["1", true, true],
            ["0", true, false],
            ["on", true, true],
            ["off", true, false],
            ["", true, false],
            ["yes", false],
            ["no", false],
            [[], false, []],
        ];
    }
}
