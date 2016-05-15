<?php

namespace sndsgd\form\rule;

/**
 * Ensure a value is at least a given amount
 */
class RequiredRule extends RuleAbstract
{
    /**
     * {@inheritdoc}
     */
    protected $description = "required";

    /**
     * {@inheritdoc}
     */
    protected $errorMessage = "required";

    /**
     * {@inheritdoc}
     */
    public function validate(
        &$value,
        \sndsgd\form\Validator $validator = null
    ): bool
    {
        return ($value !== null && $value !== "");
    }
}
