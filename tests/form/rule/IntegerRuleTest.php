<?php

namespace sndsgd\form\rule;

class IntegerRuleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerValidate
     */
    public function testValidate($test, $expect, $newValue = null)
    {
        $rule = new IntegerRule();
        $this->assertSame($expect, $rule->validate($test));
        if ($newValue !== null) {
            $this->assertSame($newValue, $value);
        }
    }

    public function providerValidate()
    {
        return [
            [-1, true],
            [0, true],
            [1, true],
            [PHP_INT_MAX, true],
            [2.4, false],
            ["asd", false],
            [new \StdClass(), false],
        ];
    }
}
