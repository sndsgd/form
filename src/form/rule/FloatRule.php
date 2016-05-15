<?php

namespace sndsgd\form\rule;

/**
 * Ensure a value is an integer
 */
class FloatRule extends RuleAbstract
{
    /**
     * {@inheritdoc}
     */
    protected $description = "type:float";

    /**
     * {@inheritdoc}
     */
    protected $errorMessage = "must be a float";

    /**
     * {@inheritdoc}
     */
    public function validate(
        &$value,
        \sndsgd\form\Validator $validator = null
    ): bool
    {
        if (is_string($value)) {
            if (
                preg_match("/^-?\d+\\.?\d+?$/", $value) &&
                ($newValue = filter_var($value, FILTER_VALIDATE_FLOAT)) !== false
            ) {
                $value = $newValue;
                return true;
            }
        } elseif (
            is_bool($value) === false &&
            ($newValue = filter_var($value, FILTER_VALIDATE_FLOAT)) !== false
        ) {
            $value = $newValue;
            return true;
        }
        return false;
    }
}
