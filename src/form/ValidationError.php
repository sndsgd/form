<?php

namespace sndsgd\form;

/**
 * A representation of a value that failed to validate
 */
class ValidationError extends \sndsgd\Error
{
    /**
     * The name of the field 
     * @var string
     */
    protected $field;

    public function __construct(string $field, string $message)
    {
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
        $ret["field"] = $this->field;
        return $ret;
    }
}
