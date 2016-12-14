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
     *
     * @var ValidatorOptions
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


    public function __construct(\sndsgd\Form $form, ValidatorOptions $options = null)
    {
        $this->form = $form;
        $this->options = $options ?? new ValidatorOptions();
    }

    public function addError(string $fieldName, string $message): Validator
    {
        $type = $this->options->getFieldType();
        $this->errors[] = new ValidationError($type, $fieldName, $message);
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

    public function getOptions(): ValidatorOptions
    {
        return $this->options;
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
