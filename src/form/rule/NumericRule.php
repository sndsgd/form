<?php

namespace sndsgd\form\rule;

/**
 * Ensure a value is a number
 */
class NumericRule extends RuleAbstract
{
    /**
     * {@inheritdoc}
     */
    protected $description = "numeric";

    /**
     * {@inheritdoc}
     */
    protected $errorMessage = "must be numeric";

    /**
     * {@inheritdoc}
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
