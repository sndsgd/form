<?php

namespace sndsgd\form\rule;

class OptionRuleTest extends \PHPUnit_Framework_TestCase
{
    public function testGetClass()
    {
        $rule = new OptionRule([1 => 1]);
        $this->assertSame(OptionRule::class, $rule->getClass());
    }

    /**
     * @dataProvider providerGetDescription
     */
    public function testGetDescription($options, $expect)
    {
        $rule = new OptionRule($options);
        $this->assertSame($expect, $rule->getDescription());
    }

    public function providerGetDescription()
    {
        return [
            [["one" => 1, "two" => 2], "in:['one','two']"],
            [[1 => 1, 2 => 2, 3 => 3], "in:[1,2,3]"],
            [[1, 2, 3], "in:[1,2,3]"],
        ];
    }

    /**
     * @dataProvider providerGetErrorMessage
     */
    public function testGetErrorMessage($options, $customMessage, $expect)
    {
        $rule = new OptionRule($options);
        if ($customMessage) {
            $rule->setErrorMessage($customMessage);
        }
        $this->assertSame($expect, $rule->getErrorMessage());
    }

    public function providerGetErrorMessage()
    {
        return [
            [["one" => 1, "two" => 2], "", "must be 'one', or 'two'"],
            [[1 => 1, 2 => 2, 3 => 3], "", "must be 1, 2, or 3"],
            [[1 => 1, 2 => 2], "test %s test", "test 1, or 2 test"],
        ];
    }

    /**
     * @dataProvider providerValidate
     */
    public function testValidate($test, $options, $expect, $newValue = null)
    {
        $rule = new OptionRule($options);
        $this->assertSame($expect, $rule->validate($test));
        if ($newValue !== null) {
            $this->assertSame($newValue, $test);
        }
    }

    public function providerValidate()
    {
        $options = [
            0 => "zero",
            1 => "one",
            2 => "two",
            "one" => "ONE",
            "two" => "TWO",
            "three" => "THREE",
        ];

        return [
            [2, [1,2,3], true, 2],
            [3, ["1","2","3"], true, "3"],
            ["0", $options, true, $options[0]],
            ["1", $options, true, $options[1]],
            ["2", $options, true, $options[2]],
            [3, $options, false, null],
            ["one", $options, true, $options["one"]],
            ["two", $options, true, $options["two"]],
            ["three", $options, true, $options["three"]],
            ["four", $options, false, null],
        ];
    }
}
