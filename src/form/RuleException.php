<?php

namespace sndsgd\form;

class RuleException extends \Exception
{
    protected $clientMessage;
    protected $fieldName;

    public function __construct(
        string $clientMessage,
        string $fieldName = ""
    )
    {
        parent::__construct("rule failed to validate", 0);
        $this->clientMessage = $clientMessage;
        $this->fieldName = $fieldName;
    }

    public function getClientMessage(): string
    {
        return $this->clientMessage;
    }

    public function getFieldName(): string
    {
        return $this->fieldName;
    }
}
