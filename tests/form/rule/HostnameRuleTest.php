<?php

namespace sndsgd\form\rule;

class HostnameRuleTest extends \PHPUnit_Framework_TestCase
{
    public function testGetDescription()
    {
        $rule = new HostnameRule();
        $this->assertEquals("hostname", $rule->getDescription());
    }

    public function testGetErrorMessage()
    {
        $rule = new HostnameRule();
        $this->assertTrue(is_string($rule->getErrorMessage()));
    }

    /**
     * @dataProvider providerValidate
     */
    public function testValidate($test, $expect)
    {
        $rule = new HostnameRule();
        $this->assertSame($expect, $rule->validate($test));
    }

    public function providerValidate()
    {
        return [
            ["/asd", false],
            ["http://", false],
            ["https://something.com", true],
            ["http://something.com/and/a/path", true],
        ];
    }
}
