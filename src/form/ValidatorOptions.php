<?php

namespace sndsgd\form;

class ValidatorOptions
{
    const DEFAULT_FIELD_TYPE = "field";

    protected $nameDelimiter = ".";
    protected $fieldType = self::DEFAULT_FIELD_TYPE;
    protected $allowUnknownFields = false;

    public function setNameDelimiter(string $nameDelimiter): ValidatorOptions
    {
        $this->nameDelimiter = $nameDelimiter;
        return $this;
    }

    public function getNameDelimiter(): string
    {
        return $this->nameDelimiter;
    }

    public function setFieldType(string $fieldType): ValidatorOptions
    {
        $this->fieldType = $fieldType;
        return $this;
    }

    public function getFieldType(): string
    {
        return $this->fieldType;
    }

    public function setAllowUnknownFields(
        bool $allowUnknownFields = false
    ): ValidatorOptions
    {
        $this->allowUnknownFields = $allowUnknownFields;
        return $this;
    }

    public function getAllowUnknownFields(): bool
    {
        return $this->allowUnknownFields;
    }
}
