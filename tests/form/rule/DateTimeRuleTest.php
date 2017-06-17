<?php

namespace sndsgd\form\rule;

class DateTimeRuleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerGetDescription
     */
    public function testGetDescription($format, $expect)
    {
        $rule = new DateTimeRule($format);
        $this->assertEquals($expect, $rule->getDescription());
    }

    public function providerGetDescription()
    {
        return [
            ["", "datetime"],
            ["Y-m-d", "datetime:Y-m-d"],
        ];
    }

    /**
     * @dataProvider providerGetErrorMessage
     */
    public function testGetErrorMessage($format, $expect)
    {
        $rule = new DateTimeRule($format);
        $this->assertEquals($expect, $rule->getErrorMessage());
    }

    public function providerGetErrorMessage()
    {
        return [
            ["", "must be a valid datetime"],
            ["Y-m-d", "must be a valid datetime of the format 'Y-m-d'"],
        ];
    }

    public function testGetErrorMessageCustom()
    {
        $rule = new DateTimeRule();
        $expect = "custom error message";
        $rule->setErrorMessage($expect);
        $this->assertSame($expect, $rule->getErrorMessage());
    }

    /**
     * @dataProvider providerValidate
     */
    public function testValidate($format, $test, $expect)
    {
        $rule = new DateTimeRule($format);
        $this->assertSame($expect, $rule->validate($test));
        if ($expect) {
            $this->assertInstanceOf(\DateTime::class, $test);
        }
    }

    public function providerValidate()
    {
        return [
            ["", "2000-01-02", true],
            ["", "2000-01-02-12-123-123", false],
            ["Y-m-d", "2000-01-02", true],
            ["Y-m-d", "2000-01-02 01:02:03", false],
        ];
    }
}
