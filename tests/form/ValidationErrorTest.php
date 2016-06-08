<?php

namespace sndsgd\form;

class ValidationErrorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerAll
     */
    public function testAll($type, $fieldName, $message, $expect)
    {
        $error = new ValidationError($type, $fieldName, $message);
        $rc = new \ReflectionClass($error);


        $this->assertSame($fieldName, $error->getField());
        $this->assertSame($expect, $error->toArray());
    }

    public function providerAll()
    {
        $ret = [];

        $name = "blegh";
        $message = "this is a required field";
        $ret[] = [
            ValidatorOptions::DEFAULT_FIELD_TYPE,
            $name,
            $message,
            [
                "message" => $message,
                "code" => 0,
                "field" => $name,
            ],
        ];

        $type = "query";
        $name = "blegh";
        $message = "this is a required field";
        $ret[] = [
            $type,
            $name,
            $message,
            [
                "message" => $message,
                "code" => 0,
                "parameter" => [
                    "type" => $type,
                    "name" => $name,
                ],
            ],
        ];

        return $ret;
    }
}
