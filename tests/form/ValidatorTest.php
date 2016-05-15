<?php

namespace sndsgd\form;

class ValidatorTest extends \PHPUnit_Framework_TestCase
{
    public function testGetForm()
    {
        $form = new \sndsgd\Form();
        $validator = new Validator($form);
        $this->assertSame($form, $validator->getForm());
    }

    public function testGetNameDelimiter()
    {
        $delimiter = ".";
        $form = new \sndsgd\Form();
        $options = ["nameDelimiter" => $delimiter];
        $validator = new Validator($form, $options);
        $this->assertSame($delimiter, $validator->getNameDelimiter());
    }

    /**
     * @dataProvider providerValidate
     */
    public function testValidate($form, $values, $expect, $exception = null)
    {
        if ($exception) {
            $this->setExpectedException($exception);
        }

        $validator = new Validator($form);
        $result = $validator->validate($values);

        $this->assertSame($expect, $result);
    }

    public function providerValidate()
    {
        return [
            [
                $this->createLoginForm(),
                [
                    "email" => "asd@asd.com",
                    "password" => "thing",
                    "remember" => 1,
                ],
                [
                    "email" => "asd@asd.com",
                    "password" => "thing",
                    "remember" => true,
                ],
                null,
            ],
            [
                $this->createLoginForm(),
                [],
                [],
                ValidationException::class,
            ],
        ];
    }


    private function createLoginForm()
    {
        return (new \sndsgd\Form())
            ->addFields(
                (new field\ScalarField("email"))
                    ->setDescription("your account email address")
                    ->addRules(
                        new rule\RequiredRule(),
                        new rule\EmailRule()
                    ),
                (new field\ScalarField("password"))
                    ->setDescription("your account password")
                    ->addRules(
                        new rule\RequiredRule()
                    ),
                (new field\ScalarField("remember"))
                    ->setDescription("whether to create an extended session")
                    ->setDefaultValue(false)
                    ->addRules(
                        new rule\BooleanRule()
                    )
            );
    }
}
