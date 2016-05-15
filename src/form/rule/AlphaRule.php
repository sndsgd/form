<?php

namespace sndsgd\form\rule;

/**
 * Ensure a value only contains alpha characters
 */
class AlphaRule extends RuleAbstract
{
    /**
     * {@inheritdoc}
     */
    protected $description = "alpha";

    /**
     * {@inheritdoc}
     */
    protected $errorMessage = "must contain only alphabetical characters";

    /**
     * {@inheritdoc}
     */
    public function validate(
        &$value,
        \sndsgd\form\Validator $validator = null
    ): bool
    {
        return ctype_alpha($value);
    }
}
