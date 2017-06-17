<?php

namespace sndsgd\form\rule;

class HostnameRuleTest extends \PHPUnit_Framework_TestCase
{
    public function testGetDescription()
    {
        $rule = new HostnameRule();
        $this->assertEquals("hostname", $rule->getDescription());
    }

    public function testGetErrorMessageDefault()
    {
        $rule = new HostnameRule();
        $expect = "must consist of at least a scheme and hostname";
        $this->assertSame($expect, $rule->getErrorMessage());
    }

    public function testGetErrorMessageCustom()
    {
        $rule = new HostnameRule();
        $expect = "custom error message";
        $rule->setErrorMessage($expect);
        $this->assertSame($expect, $rule->getErrorMessage());
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
