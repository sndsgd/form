<?php

namespace sndsgd\form\rule;

/**
 * Ensure a value only contains letters or numbers
 */
class BooleanRule extends RuleAbstract
{
    /**
     * @inheritDoc
     */
    public function getDescription(): string
    {
        return _("type:boolean");
    }

    /**
     * @inheritDoc
     */
    public function getErrorMessage(): string
    {
        if ($this->errorMessage) {
            return $this->errorMessage;
        }
        return _("must be a boolean");
    }

    /**
     * @inheritDoc
     */
    public function validate($value, \sndsgd\form\Validator $validator = null)
    {
        if (is_bool($value)) {
            return $value;
        }

        if (is_int($value)) {
            if ($value === 0) {
                return false;
            } elseif ($value === 1) {
                return true;
            }
        } elseif (is_string($value)) {
            $value = \sndsgd\Str::toBoolean($value);
            if ($value !== null) {
                return $value;
            }
        }

        throw new \sndsgd\form\RuleException("must be a boolean");
    }
}
