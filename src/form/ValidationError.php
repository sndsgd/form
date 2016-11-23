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
    protected $type;

    /**
     * The name of the field
     * @var string
     */
    protected $fieldName;


    public function __construct(string $type, string $fieldName, string $message)
    {
        $this->type = $type;
        $this->fieldName = $fieldName;
        $this->message = $message;
        $this->code = 0;
    }

    /**
     * {@inheritdoc}
     */
    public function getField(): string
    {
        return $this->fieldName;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        $ret = parent::toArray();
        if ($this->type !== ValidatorOptions::DEFAULT_FIELD_TYPE) {
            $ret["parameter"] = [
                "type" => $this->type,
                "name" => $this->fieldName,
            ];
        } else {
            $ret[$this->type] = $this->fieldName;
        }

        return $ret;
    }
}
