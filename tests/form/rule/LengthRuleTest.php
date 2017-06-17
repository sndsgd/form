<?php

namespace sndsgd\form\rule;

class LengthRuleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerConstructorException
     * @expectedException \InvalidArgumentException
     */
    public function testConstructorException($test)
    {
        new LengthRule($test);
    }

    public function providerConstructorException()
    {
        return [
            [0],
            [-1],
        ];
    }

    /**
     * @dataProvider providerGetDescription
     */
    public function testGetDescription($length, $expect)
    {
        $rule = new LengthRule($length);
        $this->assertEquals($expect, $rule->getDescription());
    }

    public function providerGetDescription()
    {
        return [
            [1, "length:1"],
            [42, "length:42"],
            [1000, "length:1,000"],
        ];
    }

    /**
     * @dataProvider providerGetErrorMessage
     */
    public function testGetErrorMessage($length, $expect)
    {
        $rule = new LengthRule($length);
        $this->assertEquals($expect, $rule->getErrorMessage());
    }

    public function providerGetErrorMessage()
    {
        return [
            [1, "must be 1 character"],
            [42, "must be 42 characters"],
            [1000, "must be 1,000 characters"],
        ];
    }

    /**
     * @dataProvider providerGetErrorMessageCustom
     */
    public function testGetErrorMessageCustom($length, $message, $expect)
    {
        $rule = new LengthRule($length);
        $rule->setErrorMessage($message);
        $this->assertSame($expect, $rule->getErrorMessage());
    }

    public function providerGetErrorMessageCustom()
    {
        return [
            [123, "test %s test", "test 123 test"],
            [123, "test two", "test two"],
        ];
    }

    /**
     * @dataProvider providerValidate
     */
    public function testValidate($length, $test, $expect)
    {
        $rule = new LengthRule($length);
        $this->assertSame($expect, $rule->validate($test));
    }

    public function providerValidate()
    {
        return [
            [1, "a", true],
            [2, "a", false],
            [1, "ab", false],
            [2, "ab", true],
        ];
    }
}
