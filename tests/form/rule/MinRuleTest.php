<?php

namespace sndsgd\form\rule;

class MinRuleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerConstructorException
     * @expectedException \InvalidArgumentException
     */
    public function testConstructorException($test)
    {
        new MinRule($test);
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
    public function testGetDescription($min, $expect)
    {
        $rule = new MinRule($min);
        $this->assertEquals($expect, $rule->getDescription());
    }

    public function providerGetDescription()
    {
        return [
            [1, "min:1"],
            [42, "min:42"],
            [-100, "min:-100"],
            [.99999, "min:0.99999"],
            [0.99999, "min:0.99999"],
        ];
    }

    /**
     * @dataProvider providerGetErrorMessage
     */
    public function testGetErrorMessage($min, $customMessage, $expect)
    {
        $rule = new MinRule($min);
        if ($customMessage) {
            $rule->setErrorMessage($customMessage);
        }
        $this->assertEquals($expect, $rule->getErrorMessage());
    }

    public function providerGetErrorMessage()
    {
        return [
            [1, "", "must be at least 1"],
            [42, "", "must be at least 42"],
            [-100, "", "must be at least -100"],
            [.99999, "", "must be at least 0.99999"],
            [0.99999, "", "must be at least 0.99999"],
            [42, "test %s", "test 42"],
        ];
    }

    /**
     * @dataProvider providerValidate
     */
    public function testValidate($min, $test, $expect)
    {
        $rule = new MinRule($min);
        $this->assertSame($expect, $rule->validate($test));
    }

    public function providerValidate()
    {
        return [
            [1, 1, true],
            [1, .9999999, false],
            [1, 0, false],
            [1, -1, false],
            [PHP_INT_MAX, PHP_INT_MAX, true],
            [.9999999, .9999998, false],
        ];
    }
}
