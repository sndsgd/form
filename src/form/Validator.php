<?php

namespace sndsgd\form;

class Validator
{
    /**
     * The default string to use in error messages for nested keys
     *
     * @var string
     */
    const DEFAULT_NAME_DELIMITER = " 》";

    /**
     * @var \sndsgd\Form
     */
    protected $form;

    /**
     * Configuration options
     * @todo replace this with a config object
     *
     * @var array
     */
    protected $options;

    /**
     * Errors encountered during validation are stashed here
     *
     * @var array<\sndsgd\ErrorInterface>
     */
    protected $errors = [];

    /**
     * The values to validate
     *
     * @var array
     */
    protected $values;
    
    public function __construct(\sndsgd\Form $form, array $options = [])
    {
        $this->form = $form;
        $this->options = array_merge([
            "nameDelimiter" => static::DEFAULT_NAME_DELIMITER,
        ], $options);
    }

    public function addError(string $fieldName, string $message): Validator
    {
        $this->errors[] = new ValidationError($fieldName, $message);
        return $this;
    }

    /**
     * @return array<\sndsgd\form\ValidationError>
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getForm(): \sndsgd\Form
    {
        return $this->form;
    }

    public function getNameDelimiter(): string
    {
        return $this->options["nameDelimiter"];
    }

    public function validate(array $values = [])
    {
        $this->values = $values;
        $results = $this->form->validate($this->values, $this);
        if (empty($this->errors)) {
            return $results;
        }
        
        throw (new \sndsgd\form\ValidationException("validation error"))
            ->setErrors($this->errors);
    }
}
