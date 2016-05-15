<?php

namespace sndsgd\form\field;

class ScalarFieldTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerSetDefaultValue
     */
    public function testSetDefaultValue($value, $exception = '')
    {
        if ($exception) {
            $this->setExpectedException($exception);
        }

        $field = new ScalarField("test");
        $field->setDefaultValue($value);
        $this->assertSame($value, $field->getDefaultValue());
    }

    public function providerSetDefaultValue()
    {
        return [
            [1, ""],
            [1.1, ""],
            ["blegh", ""],
            [null, ""],
            [[], \InvalidArgumentException::class],
            [new \StdClass(), \InvalidArgumentException::class],
        ];
    }

    /**
     * @dataProvider providerValidate
     */
    public function testValidate($field, $values, $errorCount, $expect)
    {
        $form = new \sndsgd\Form();
        $validator = new \sndsgd\form\Validator($form);
        $result = $field->validate($values, $validator);

        $errors = $validator->getErrors();
        $this->assertCount($errorCount, $errors);

        $this->assertSame($expect, $result);
    }

    public function providerValidate()
    {
        return [
            # fail: an array of multiple values
            [
                new ScalarField("test"),
                [1, 2],
                1,
                null,
            ],

            # pass: an array with a single value
            [
                new ScalarField("test"),
                [1],
                0,
                1,
            ],

            # pass: no value and not required
            [
                (new ScalarField("test"))->setDefaultValue(42),
                null,
                0,
                42,
            ],

            # pass: rules pass validation
            [
                (new ScalarField("test"))
                    ->addRules(
                        new \sndsgd\form\rule\RequiredRule(),
                        new \sndsgd\form\rule\IntegerRule()
                    ),
                "42",
                0,
                42,
            ],

            # fail: a rule doesn't pass validation
            [
                (new ScalarField("test"))
                    ->addRules(
                        new \sndsgd\form\rule\RequiredRule(),
                        new \sndsgd\form\rule\IntegerRule()
                    ),
                "abc",
                1,
                null,
            ],
        ];
    }
}
