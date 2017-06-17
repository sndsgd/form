<?php

namespace sndsgd\form\rule;

class AlphaRuleTest extends \PHPUnit_Framework_TestCase
{
    public function testGetClass()
    {
        $rule = new AlphaRule();
        $this->assertSame(AlphaRule::class, $rule->getClass());
    }

    public function testGetDescription()
    {
        $rule = new AlphaRule();
        $this->assertSame("alpha", $rule->getDescription());
    }

    public function testGetErrorMessageDefault()
    {
        $rule = new AlphaRule();
        $expect = "must contain only alphabetical characters";
        $this->assertSame($expect, $rule->getErrorMessage());
    }

    public function testGetErrorMessageCustom()
    {
        $rule = new AlphaRule();
        $expect = "custom error message";
        $rule->setErrorMessage($expect);
        $this->assertSame($expect, $rule->getErrorMessage());
    }

    /**
     * @dataProvider providerValidate
     */
    public function testValidate($test, $expect, $newValue = null)
    {
        $rule = new AlphaRule();
        $this->assertSame($expect, $rule->validate($test));
        if ($newValue !== null) {
            $this->assertSame($newValue, $value);
        }
    }

    public function providerValidate()
    {
        return [
            ["abc", true],
            ["abc123", false],
            ["abc.", false], // '.' isn't a letter or number
            [0, false], // integers aren't strings
            [4.2, false], // floats aren't strings
            [new \StdClass(), false],
        ];
    }
}
