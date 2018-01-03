<?php

namespace sndsgd\form\rule;

/**
 * Ensure a value is an integer
 */
class IntegerRule extends RuleAbstract
{
    /**
     * @inheritDoc
     */
    public function getDescription(): string
    {
        return _("type:integer");
    }

    /**
     * @inheritDoc
     */
    public function getErrorMessage(): string
    {
        if ($this->errorMessage) {
            return $this->errorMessage;
        }
        return _("must be an integer");
    }

    /**
     * @inheritDoc
     */
    public function validate($value, \sndsgd\form\Validator $validator = null)
    {
        if (
            !is_bool($value) &&
            $value !== null &&
            ($value = filter_var($value, FILTER_VALIDATE_INT)) !== false
        ) {
            return $value;
        }

        throw new \sndsgd\form\RuleException("must be an integer");
    }
}
