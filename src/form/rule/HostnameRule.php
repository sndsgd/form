<?php

namespace sndsgd\form\rule;

/**
 * Ensure a URL is a valid hostname
 */
class HostnameRule extends RuleAbstract
{
    /**
     * {@inheritdoc}
     */
    public function getDescription(): string
    {
        return _("hostname");
    }

    /**
     * {@inheritdoc}
     */
    public function getErrorMessage(): string
    {
        if ($this->errorMessage) {
            return $this->errorMessage;
        }
        return _("must consist of at least a scheme and hostname");
    }

    /**
     * {@inheritdoc}
     */
    public function validate(
        &$value,
        \sndsgd\form\Validator $validator = null
    ): bool
    {
        $url = parse_url($value);
        return (
            is_array($url) &&
            array_key_exists("scheme", $url) &&
            array_key_exists("host", $url)
        );
    }
}
