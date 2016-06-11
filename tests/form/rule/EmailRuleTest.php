<?php

namespace sndsgd\form\rule;

class EmailRuleTest extends \PHPUnit_Framework_TestCase
{
    public function testGetClass()
    {
        $rule = new EmailRule();
        $this->assertSame(EmailRule::class, $rule->getClass());
    }

    public function testGetDescription()
    {
        $rule = new EmailRule();
        $this->assertSame("email", $rule->getDescription());
    }

    /**
     * @dataProvider providerGetErrorMessage
     */
    public function testGetErrorMessage($customMessage, $expect)
    {
        $rule = new EmailRule();
        if ($customMessage) {
            $rule->setErrorMessage($customMessage);
        }
        $this->assertEquals($expect, $rule->getErrorMessage());
    }

    public function providerGetErrorMessage()
    {
        return [
            ["", "must be a valid email address"],
            ["custom error message", "custom error message"],
        ];
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
