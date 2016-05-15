<?php

namespace sndsgd\form\rule;

class MaxLengthRuleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerConstructorException
     * @expectedException \InvalidArgumentException
     */
    public function testConstructorException($test)
    {
        new MaxLengthRule($test);
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
    public function testGetDescription($max, $expect)
    {
        $rule = new MaxLengthRule($max);
        $this->assertEquals($expect, $rule->getDescription());
    }

    public function providerGetDescription()
    {
        return [
            [1, "max-length:1"],
            [42, "max-length:42"],
            [1000, "max-length:1,000"],
        ];
    }

    /**
     * @dataProvider providerGetErrorMessage
     */
    public function testGetErrorMessage($max, $expect)
    {
        $rule = new MaxLengthRule($max);
        $this->assertEquals($expect, $rule->getErrorMessage());
    }

    public function providerGetErrorMessage()
    {
        return [
            [1, "must be no more than 1 character"],
            [42, "must be no more than 42 characters"],
            [1000, "must be no more than 1,000 characters"],
        ];
    }

    /**
     * @dataProvider providerValidate
     */
    public function testValidate($max, $test, $expect)
    {
        $rule = new MaxLengthRule($max);
        $this->assertSame($expect, $rule->validate($test));
    }

    public function providerValidate()
    {
        return [
            [1, "a", true],
            [2, "a", true],
            [1, "ab", false],
            [2, "abc", false],
        ];
    }
}
