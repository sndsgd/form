<?php

namespace sndsgd\form\rule;

class FloatRuleTest extends \PHPUnit_Framework_TestCase
{
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
