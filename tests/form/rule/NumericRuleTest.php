<?php

namespace sndsgd\form\rule;

class NumericRuleTest extends \PHPUnit_Framework_TestCase
{
    public function testGetDescription()
    {
        $rule = new NumericRule();
        $this->assertEquals("numeric", $rule->getDescription());
    }

    public function testGetErrorMessage()
    {
        $rule = new NumericRule();
        $this->assertEquals("must be numeric", $rule->getErrorMessage());
    }

    /**
     * @dataProvider providerValidate
     */
    public function testValidate($test, $expect, $newValue)
    {
        $rule = new NumericRule();
        $this->assertSame($expect, $rule->validate($test));
        if ($newValue !== null) {
            $this->assertSame($newValue, $test);
        }
    }

    public function providerValidate()
    {
        return [
            ["asd", false, null],
            ["123", true, 123.0],

        ];
    }
}
