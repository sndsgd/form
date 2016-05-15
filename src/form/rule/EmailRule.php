<?php

namespace sndsgd\form\rule;

/**
 * Ensure a value is a valid email address
 */
class EmailRule extends RuleAbstract
{
    /**
     * {@inheritdoc}
     */    
    protected $description = "email";

    /**
     * {@inheritdoc}
     */
    protected $errorMessage = "must be a valid email address";

    /**
     * {@inheritdoc}
     */
    public function validate(
        &$value,
        \sndsgd\form\Validator $validator = null
    ): bool
    {
        $email = filter_var($value, FILTER_VALIDATE_EMAIL);
        if ($email !== false) {
            $value = $email;
            return true;
        }
        return false;
    }
}
