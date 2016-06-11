<?php

namespace sndsgd\form\rule;

class MinValueCountRuleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerConstructorException
     * @expectedException \InvalidArgumentException
     */
    public function testConstructorException($test)
    {
        new MinValueCountRule($test);
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
    public function testGetDescription($minValues, $expect)
    {
        $rule = new MinValueCountRule($minValues);
        $this->assertEquals($expect, $rule->getDescription());
    }

    public function providerGetDescription()
    {
        return [
            [1, "min-values:1"],
            [42, "min-values:42"],
            [100, "min-values:100"],
        ];
    }

    /**
     * @dataProvider providerGetErrorMessage
     */
    public function testGetErrorMessage($minValues, $customMessage, $expect)
    {
        $rule = new MinValueCountRule($minValues);
        if ($customMessage) {
            $rule->setErrorMessage($customMessage);
        }
        $this->assertEquals($expect, $rule->getErrorMessage());
    }

    public function providerGetErrorMessage()
    {
        return [
            [1, "", "must be no less than 1 value"],
            [2, "", "must be no less than 2 values"],
            [42, "", "must be no less than 42 values"],
            [42, "testing %s", "testing 42"],
        ];
    }

    /**
     * @dataProvider providerValidate
     */
    public function testValidate($minValues, $values, $expect)
    {
        $rule = new MinValueCountRule($minValues);
        $this->assertSame($expect, $rule->validate($values));
    }

    public function providerValidate()
    {
        return [
            [1, [1], true],
            [2, [1, 2], true],
            [1, [1, 2], true],
            [2, [1], false],
            [3, [1, 2], false],
        ];
    }
}
