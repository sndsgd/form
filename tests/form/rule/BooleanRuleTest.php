<?php

namespace sndsgd\form\rule;

class BooleanRuleTest extends \PHPUnit_Framework_TestCase
{
    public function testGetClass()
    {
        $rule = new BooleanRule();
        $this->assertSame(BooleanRule::class, $rule->getClass());
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
