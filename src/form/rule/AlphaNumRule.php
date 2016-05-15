<?php

namespace sndsgd\form\rule;

/**
 * Ensure a value only contains letters or numbers
 */
class AlphaNumRule extends RuleAbstract
{
    /**
     * {@inheritdoc}
     */
    protected $description = "alphanumeric";

    /**
     * {@inheritdoc}
     */
    protected $errorMessage = "must contain only alphanumeric characters";

    /**
     * {@inheritdoc}
     */
    public function validate(
        &$value,
        \sndsgd\form\Validator $validator = null
    ): bool
    {
        return ctype_alnum($value);
    }
}
