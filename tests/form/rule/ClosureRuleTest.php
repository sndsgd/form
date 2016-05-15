<?php

namespace sndsgd\form\rule;

class ClosureRuleTest extends \PHPUnit_Framework_TestCase
{
    public static function validRule(
        $value,
        \sndsgd\form\Validator $validator = null
    ): bool
    {
        return is_string($value);
    }

    // note the lack of the return type
    public static function invalidRule(
        &$value,
        \sndsgd\form\Validator $validator = null
    )
    {
        return is_string($value);
    }

    /**
     * @dataProvider providerConstructorException
     * @expectedException \InvalidArgumentException
     */
    public function testConstructorException($rule)
    {
        $rule = new ClosureRule($rule);
    }

    public function providerConstructorException()
    {
        return [
            [__CLASS__."::invalidRule"],
            [function($too, $many, $params) { return true; }],
            [function($value, $validator) { return true; }],
            [function($value, $validator): bool { return true; }],
            [function($value, $validator) { return true; }],
            [function(&$value = null, $validator = null) { return true; }],
        ];
    }

    public function testGetClass()
    {
        $rule = new ClosureRule(__CLASS__."::validRule");
        $this->assertTrue(is_string($rule->getClass()));

        $rule = new ClosureRule(function(
            &$field,
            \sndsgd\form\Validator $validator = null
        ): bool
        {
            $value = $field->getValue($index);
            if ($value == 123) {
                $field->setValue(123);
                return true;
            }
            return false;
        });
        $this->assertTrue(is_string($rule->getClass()));
    }

    /**
     * @dataProvider providerValidate
     */
    public function testValidate($handler, $value, $expect)
    {
        $rule = new ClosureRule($handler);
        $this->assertSame($expect, $rule->validate($value));
    }

    public function providerValidate()
    {
        return [
            [__CLASS__."::validRule", "string", true],
            [__CLASS__."::validRule", new \StdClass(), false],
        ];
    }
}
