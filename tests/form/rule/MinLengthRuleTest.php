<?php

namespace sndsgd\form\rule;

class MinLengthRuleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerConstructorException
     * @expectedException \InvalidArgumentException
     */
    public function testConstructorException($test)
    {
        new MinLengthRule($test);
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
    public function testGetDescription($min, $expect)
    {
        $rule = new MinLengthRule($min);
        $this->assertEquals($expect, $rule->getDescription());
    }

    public function providerGetDescription()
    {
        return [
            [1, "min-length:1"],
            [42, "min-length:42"],
            [1000, "min-length:1,000"],
        ];
    }

    /**
     * @dataProvider providerGetErrorMessage
     */
    public function testGetErrorMessage($min, $customMessage, $expect)
    {
        $rule = new MinLengthRule($min);
        if ($customMessage) {
            $rule->setErrorMessage($customMessage);
        }
        $this->assertEquals($expect, $rule->getErrorMessage());
    }

    public function providerGetErrorMessage()
    {
        return [
            [1, "", "must be at least 1 character"],
            [42, "", "must be at least 42 characters"],
            [1000, "", "must be at least 1,000 characters"],
            [42, "test %s", "test 42"],
        ];
    }

    /**
     * @dataProvider providerValidate
     */
    public function testValidate($min, $test, $expect)
    {
        $rule = new MinLengthRule($min);
        $this->assertSame($expect, $rule->validate($test));
    }

    public function providerValidate()
    {
        return [
            [1, "a", true],
            [1, "ab", true],
            [2, "a", false],
            [3, "ab", false],
        ];
    }
}
