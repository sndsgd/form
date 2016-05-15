<?php

namespace sndsgd\form;

class ValidationErrorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerAll
     */
    public function testAll($field, $message)
    {
        $error = new ValidationError($field, $message);
        $rc = new \ReflectionClass($error);


        $this->assertSame($field, $error->getField());

        $expect = [
            "message" => $message,
            "code" => 0,
            "field" => $field
        ];
        $this->assertSame($expect, $error->toArray());
    }

    public function providerAll()
    {
        return [
            ["name", "this is a required field"],
            ["age", "must be at least 1"],
        ];
    }
}
