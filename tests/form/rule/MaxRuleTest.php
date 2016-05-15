<?php

namespace sndsgd\form\rule;

class MaxRuleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerConstructorException
     * @expectedException \InvalidArgumentException
     */
    public function testConstructorException($test)
    {
        new MaxRule($test);
    }

    public function providerConstructorException()
    {
        return [
            ["string"],
            [true],
            [false],
            [null],
            [new \StdClass()],
            [[1, 2, 3]],
        ];
    }

    /**
     * @dataProvider providerGetDescription
     */
    public function testGetDescription($max, $expect)
    {
        $rule = new MaxRule($max);
        $this->assertEquals($expect, $rule->getDescription());
    }

    public function providerGetDescription()
    {
        return [
            [1, "max:1"],
            [42, "max:42"],
            [-100, "max:-100"],
            [.99999, "max:0.99999"],
            [0.99999, "max:0.99999"],
        ];
    }

    /**
     * @dataProvider providerGetErrorMessage
     */
    public function testGetErrorMessage($max, $expect)
    {
        $rule = new MaxRule($max);
        $message = "must be no greater than {$expect}";
        $this->assertEquals($message, $rule->getErrorMessage());
    }

    public function providerGetErrorMessage()
    {
        return [
            [1, 1],
            [42, 42],
            [-100, -100],
            [.99999, 0.99999],
            [0.99999, 0.99999],
        ];
    }

    /**
     * @dataProvider providerValidate
     */
    public function testValidate($max, $test, $expect)
    {
        $rule = new MaxRule($max);
        $this->assertSame($expect, $rule->validate($test));
    }

    public function providerValidate()
    {
        return [
            [1, 1, true],
            [1, 2, false],
            [1, 1.000001, false],
            [PHP_INT_MAX - 1, PHP_INT_MAX, false],
            [2.4449, 2.4450, false],
        ];
    }
}
