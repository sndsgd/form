<?php

namespace sndsgd\form\rule;

class RegexRuleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerConstructorException
     * @expectedException \InvalidArgumentException
     */
    public function testConstructorException($test)
    {
        new RegexRule($test);
    }

    public function providerConstructorException()
    {
        return [
            ["blegh"],
            ["/nooooope"],
            ["/[^a-z]/1"],
        ];
    }

    /**
     * @dataProvider providerGetDescription
     */
    public function testGetDescription($regex)
    {
        $rule = new RegexRule($regex);
        $expect = "regex:$regex";
        $this->assertEquals($expect, $rule->getDescription());
    }

    public function providerGetDescription()
    {
        return [
            ["/[a-z0-9]+/"],
        ];
    }

    /**
     * @dataProvider providerGetErrorMessage
     */
    public function testGetErrorMessage($regex, $message = null, $expect = "")
    {
        $rule = new RegexRule($regex);
        if ($message !== null) {
            $rule->setErrorMessage($message);
        }
        $this->assertEquals($expect, $rule->getErrorMessage());
    }

    public function providerGetErrorMessage()
    {
        $regex = "/^[A-Z]+$/";
        return [
            [$regex, null, "must match regex pattern"],
            [$regex, "test %s", "test $regex"],
            [$regex, "test %s testing", "test $regex testing"],
        ];
    }

    /**
     * @dataProvider providerValidate
     */
    public function testValidate($regex, $value, $expect)
    {
        $rule = new RegexRule($regex);
        $this->assertSame($expect, $rule->validate($value));
    }

    public function providerValidate()
    {
        return [
            ["/^[A-Z]+$/", "TEST", true],
            ["/^[A-Z]+$/", "TesT", false],
            ["/[A-Z]+/", "test", false],
        ];
    }
}
