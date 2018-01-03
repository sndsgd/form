<?php

namespace sndsgd\form;

class Validator
{
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


    protected $nameList = [];


    public function __construct(\sndsgd\Form $form, ValidatorOptions $options = null)
    {
        $this->form = $form;
        $this->options = $options ?? new ValidatorOptions();
    }

    public function addError(string $message, string $fieldName = ""): Validator
    {
        if ($fieldName === "") {
            $fieldName = $this->getName();
        }

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

    public function appendName(string $name)
    {
        $this->nameList[] = $name;
    }

    public function popName(): string
    {
        return array_pop($this->nameList) ?? "";
    }

    public function getName(string ...$names): string
    {
        return implode(".", array_merge($this->nameList, $names));
    }

    public function getValue(string $name)
    {
        $search = &$this->values;
        $parts = explode(".", $name);
        foreach ($parts as $name) {
            if (!isset($search[$name])) {
                return null;
            }

            $search = &$search[$name];
        }

        return $search;
    }

    public function getRelativeValue(string $relativeName)
    {
        $nameParts = $this->nameList;
        $relativeParts = explode(".", $relativeName);

        foreach ($relativeParts as $name) {
            if ($name === "") {
                if (array_pop($nameParts) === null) {
                    throw new \Exception("failed to traverse up past root");
                }
            } else {
                $nameParts[] = $name;
            }
        }

        return $this->getValue(implode(".", $nameParts));
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
