<?php

namespace sndsgd\form\rule;

/**
 * Ensure a value is a valid email address
 */
class EmailRule extends RuleAbstract
{
    /**
     * @inheritDoc
     */
    public function getDescription(): string
    {
        return _("email");
    }

    /**
     * @inheritDoc
     */
    public function getErrorMessage(): string
    {
        if ($this->errorMessage) {
            return $this->errorMessage;
        }
        return _("must be a valid email address");
    }

    /**
     * @inheritDoc
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
