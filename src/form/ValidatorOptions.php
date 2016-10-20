<?php

namespace sndsgd\form;

class ValidatorOptions
{
    const DEFAULT_FIELD_TYPE = "field";

    protected $nameDelimiter = " 》";
    protected $fieldType = self::DEFAULT_FIELD_TYPE;

    /**
     * @param string $nameDelimiter
     */
    public function setNameDelimiter($nameDelimiter)
    {
        $this->nameDelimiter = $nameDelimiter;
        return $this;
    }

    /**
     * @return string
     */
    public function getNameDelimiter()
    {
        return $this->nameDelimiter;
    }

    /**
     * @param string $fieldType
     */
    public function setFieldType($fieldType)
    {
        $this->fieldType = $fieldType;
        return $this;
    }

    /**
     * @return string
     */
    public function getFieldType()
    {
        return $this->fieldType;
    }
}
