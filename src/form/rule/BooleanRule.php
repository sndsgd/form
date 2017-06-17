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
    public function validate(
        &$value,
        \sndsgd\form\Validator $validator = null
    ): bool
    {
        if (is_bool($value)) {
            return true;
        } elseif (is_int($value)) {
            if ($value === 0) {
                $value = false;
                return true;
            } elseif ($value === 1) {
                $value = true;
                return true;
            }
            return false;
        } elseif (is_string($value)) {
            if (($newValue = \sndsgd\Str::toBoolean($value)) !== null) {
                $value = $newValue;
                return true;
            }
            return false;
        }
        return false;
    }
}
