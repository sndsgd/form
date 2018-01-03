<?php

namespace sndsgd\form\rule;

/**
 * Ensure a value is an integer
 */
class FloatRule extends RuleAbstract
{
    /**
     * @inheritDoc
     */
    public function getDescription(): string
    {
        return _("type:float");
    }

    /**
     * @inheritDoc
     */
    public function getErrorMessage(): string
    {
        if ($this->errorMessage) {
            return $this->errorMessage;
        }
        return _("must be a float");
    }

    /**
     * @inheritDoc
     */
    public function validate($value, \sndsgd\form\Validator $validator = null)
    {
        if (is_string($value)) {
            if (
                preg_match("/^-?\d+\\.?\d+?$/", $value) &&
                ($value = filter_var($value, FILTER_VALIDATE_FLOAT)) !== false
            ) {
                return $value;
            }
        } elseif (
            !is_bool($value) &&
            ($value = filter_var($value, FILTER_VALIDATE_FLOAT)) !== false
        ) {
            return $value;
        }

        throw new \sndsgd\form\RuleException($this->getErrorMessage());
    }
}
