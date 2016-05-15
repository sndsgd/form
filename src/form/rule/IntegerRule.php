<?php

namespace sndsgd\form\rule;

/**
 * Ensure a value is an integer
 */
class IntegerRule extends RuleAbstract
{
    /**
     * {@inheritdoc}
     */
    protected $description = "type:integer";

    /**
     * {@inheritdoc}
     */
    protected $errorMessage = "must be an integer";

    /**
     * {@inheritdoc}
     */
    public function validate(&$value, \sndsgd\form\Validator $validator = null): bool
    {
        if (
            is_bool($value) === false &&
            $value !== null &&
            ($newValue = filter_var($value, FILTER_VALIDATE_INT)) !== false
        ) {
            $value = $newValue;
            return true;
        }
        return false;
    }
}
