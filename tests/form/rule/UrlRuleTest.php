<?php

namespace sndsgd\form\rule;

class UrlRuleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerConstructorException
     * @expectedException \InvalidArgumentException
     */
    public function testConstructorException($test)
    {
        new UrlRule($test);
    }

    public function providerConstructorException()
    {
        return [
            [["nope"]],
            [["host", false, true]],
        ];
    }

    /**
     * @dataProvider providerGetDescription
     */
    public function testGetDescription($parts, $expect)
    {
        $rule = new UrlRule($parts);
        $this->assertEquals($expect, $rule->getDescription());
    }

    public function providerGetDescription()
    {
        return [
            [["scheme", "host"], "url"],
        ];
    }

    /**
     * @dataProvider providerGetErrorMessage
     */
    public function testGetErrorMessage($parts, $customMessage, $expect)
    {
        $rule = new UrlRule($parts);
        if ($customMessage) {
            $rule->setErrorMessage($customMessage);
        }
        $this->assertEquals($expect, $rule->getErrorMessage());
    }

    public function providerGetErrorMessage()
    {
        return [
            [["scheme", "host"], "", "must be a valid URL"],
        ];
    }

    public function testGetErrorMessageCustom()
    {
        $rule = new UrlRule(["host"]);
        $expect = "custom error message";
        $rule->setErrorMessage($expect);
        $this->assertSame($expect, $rule->getErrorMessage());
    }

    /**
     * @dataProvider providerValidate
     */
    public function testValidate($parts, $test, $expect)
    {
        $rule = new UrlRule($parts);
        $this->assertSame($expect, $rule->validate($test));
    }

    public function providerValidate()
    {
        return [
            [["host"], "http://:80", false],
            [["host"], "nooooooo", false],
            [["host"], "https://something.com", true],
            [["scheme", "host"], "https://something.com", true],
            [["path"], "https://something.com", false],
            [["host"], "ftp://💩/💩", true],
        ];
    }
}
