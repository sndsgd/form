<?php

namespace sndsgd\form\rule;

class EmailRuleTest extends \PHPUnit_Framework_TestCase
{
    public function testGetClass()
    {
        $rule = new EmailRule();
        $this->assertSame(EmailRule::class, $rule->getClass());
    }

    /**
     * @dataProvider providerValidate
     */
    public function testValidate($test, $expect, $newValue = null)
    {
        $rule = new EmailRule();
        $this->assertSame($expect, $rule->validate($test));
        if ($newValue !== null) {
            $this->assertSame($newValue, $test);
        }
    }

    public function providerValidate()
    {
        return [
            ["user@domain.com", true],
            ["user@domain.com.com", true],
            ["abc", false],
            ["abc123", false],
            ["abc@abc", false],
            ["abc.", false],
            [0, false],
            [4.2, false],
            [new \StdClass(), false],
        ];
    }
}
