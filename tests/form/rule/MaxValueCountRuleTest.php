<?php

namespace sndsgd\form\rule;

class MaxValueCountRuleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerConstructorException
     * @expectedException \InvalidArgumentException
     */
    public function testConstructorException($test)
    {
        new MaxValueCountRule($test);
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
    public function testGetDescription($maxValues, $expect)
    {
        $rule = new MaxValueCountRule($maxValues);
        $this->assertEquals($expect, $rule->getDescription());
    }

    public function providerGetDescription()
    {
        return [
            [1, "max-values:1"],
            [42, "max-values:42"],
            [100, "max-values:100"],
        ];
    }

    /**
     * @dataProvider providerGetErrorMessage
     */
    public function testGetErrorMessage($maxValues, $customMessage, $expect)
    {
        $rule = new MaxValueCountRule($maxValues);
        if ($customMessage) {
            $rule->setErrorMessage($customMessage);
        }
        $this->assertEquals($expect, $rule->getErrorMessage());
    }

    public function providerGetErrorMessage()
    {
        return [
            [1, "", "must be no more than 1 value"],
            [2, "", "must be no more than 2 values"],
            [42, "", "must be no more than 42 values"],
            [42, "test %s", "test 42"],
        ];
    }

    /**
     * @dataProvider providerValidate
     */
    public function testValidate($maxValues, $values, $expect)
    {
        $rule = new MaxValueCountRule($maxValues);
        $this->assertSame($expect, $rule->validate($values));
    }

    public function providerValidate()
    {
        return [
            [1, [1], true],
            [1, [1, 2], false],
            [2, [1, 2], true],
            [2, [1], true],
            [2, [1, 2, 3, 4], false],
        ];
    }
}
