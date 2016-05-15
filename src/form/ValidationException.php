<?php

namespace sndsgd\form;

class ValidationException extends \Exception
{
    protected $errors = [];

    public function setErrors(array $errors): ValidationException
    {
        $this->errors = $errors;
        return $this;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
