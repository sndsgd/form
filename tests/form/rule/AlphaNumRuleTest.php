<?php

namespace sndsgd\form\rule;

class AlphaNumRuleTest extends \PHPUnit_Framework_TestCase
{
    public function testGetClass()
    {
        $rule = new AlphaNumRule();
        $this->assertSame(AlphaNumRule::class, $rule->getClass());
    }

    public function testGetDescription()
    {
        $rule = new AlphaNumRule();
        $this->assertSame("alphanumeric", $rule->getDescription());
    }

    /**
     * @dataProvider providerGetErrorMessage
     */
    public function testGetErrorMessage($customMessage, $expect)
    {
        $rule = new AlphaNumRule();
        if ($customMessage) {
            $rule->setErrorMessage($customMessage);
        }
        $this->assertEquals($expect, $rule->getErrorMessage());
    }

    public function providerGetErrorMessage()
    {
        return [
            ["", "must contain only alphanumeric characters"],
            ["custom error message", "custom error message"],
        ];
    }

    /**
     * @dataProvider providerValidate
     */
    public function testValidate($test, $expect, $newValue = null)
    {
        $rule = new AlphaNumRule();
        $this->assertSame($expect, $rule->validate($test));
        if ($newValue !== null) {
            $this->assertSame($newValue, $value);
        }
    }

    public function providerValidate()
    {
        return [
            ["123", true],
            ["abc", true],
            ["123abc", true],
            ["123.00", false], // '.' isn't a letter or number
            [0, false], // integers aren't strings
            [4.2, false], // floats aren't strings
            [new \StdClass(), false],
        ];
    }
}
