<?php

namespace sndsgd\form;

/**
 * A representation of a value that failed to validate
 */
class ValidationError extends \sndsgd\Error
{
    /**
     * The key for the field value in the array representation
     *
     * @var string
     */
    protected $fieldType;

    /**
     * The name of the field 
     * @var string
     */
    protected $field;


    public function __construct(string $fieldType, string $field, string $message)
    {
        print_r($this->fieldType);
        $this->fieldType = $fieldType;
        $this->field = $field;
        $this->message = $message;
        $this->code = 0;
    }

    /**
     * {@inheritdoc}
     */
    public function getField(): string
    {
        return $this->field;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        $ret = parent::toArray();
        if ($this->fieldType !== ValidatorOptions::DEFAULT_FIELD_TYPE) {
            $ret["parameter"] = [
                "type" => $this->fieldType,
                "name" => $this->field,
            ];
        } else {
            $ret[$this->fieldType] = $this->field;
        }
        
        return $ret;
    }
}
