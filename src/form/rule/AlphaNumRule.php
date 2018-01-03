<?php

namespace sndsgd\form\rule;

/**
 * Ensure a value only contains letters or numbers
 */
class AlphaNumRule extends RuleAbstract
{
    /**
     * @inheritDoc
     */
    public function getDescription(): string
    {
        return _("alphanumeric");
    }

    /**
     * @inheritDoc
     */
    public function getErrorMessage(): string
    {
        if ($this->errorMessage) {
            return $this->errorMessage;
        }
        return _("must contain only alphanumeric characters");
    }

    /**
     * @inheritDoc
     */
    public function validate($value, \sndsgd\form\Validator $validator = null)
    {
        if (!ctype_alnum($value)) {
            throw new \sndsgd\form\RuleException($this->getErrorMessage());
        }

        return $value;
    }
}
