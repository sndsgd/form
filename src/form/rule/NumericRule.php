<?php

namespace sndsgd\form\rule;

/**
 * Ensure a value is a number
 */
class NumericRule extends RuleAbstract
{
    /**
     * @inheritDoc
     */
    public function getDescription(): string
    {
        return _("numeric");
    }

    /**
     * @inheritDoc
     */
    public function getErrorMessage(): string
    {
        if ($this->errorMessage) {
            return $this->errorMessage;
        }
        return _("must be numeric");
    }

    /**
     * @inheritDoc
     */
    public function validate(
        &$value,
        \sndsgd\form\Validator $validator = null
    ): bool
    {
        if ($value === 0 || is_numeric($value)) {
            $value = floatval($value);
            return true;
        }
        return false;
    }
}
