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
        $rc = new \ReflectionClass($rule);
        $property = $rc->getProperty("errorMessage");
        $property->setAccessible(true);
        $errorMessage = $property->getValue($rule);
        $this->assertEquals($errorMessage, $rule->getErrorMessage());
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
