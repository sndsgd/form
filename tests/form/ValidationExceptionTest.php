<?php

namespace sndsgd\form;

class ValidationExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testSetGetErrors()
    {
        $errors = [1,2,3];

        $ex = new ValidationException();
        $ex->setErrors($errors);
        $this->assertSame($errors, $ex->getErrors());
    }
}
