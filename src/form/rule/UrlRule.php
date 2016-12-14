<?php

namespace sndsgd\form\rule;

/**
 * Ensure a value is a valid url
 */
class UrlRule extends RuleAbstract
{
    /**
     * A map of the valid url parts
     *
     * @var array<string,string>
     */
    protected static $validParts = [
        "scheme" => true,
        "user" => true,
        "pass" => true,
        "host" => true,
        "port" => true,
        "path" => true,
        "query" => true,
        "fragment" => true,
    ];

    /**
     * The parts that must exist for the url to be valid
     *
     * @var array<string>
     */
    protected $requiredParts;

    /**
     * @param  array<string> $requiredParts
     */
    public function __construct(array $requiredParts = [])
    {
        foreach ($requiredParts as $part) {
            if (!isset(static::$validParts[$part])) {
                throw new \InvalidArgumentException(
                    "invalid value provided for 'requiredParts'; expecting ".
                    "an array of url part descriptions"
                );
            }
        }
        $this->requiredParts = $requiredParts;
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription(): string
    {
        return _("url");
    }

    /**
     * {@inheritdoc}
     */
    public function getErrorMessage(): string
    {
        if ($this->errorMessage) {
            return $this->errorMessage;
        }
        return _("must be a valid URL");
    }

    /**
     * {@inheritdoc}
     *
     * Note: `filter_var()` with `FILTER_VALIDATE_URL` doesn't seem to be
     * able to handle non ascii charsets
     */
    public function validate(
        &$value,
        \sndsgd\form\Validator $validator = null
    ): bool
    {
        $url = parse_url($value);
        if (!is_array($url)) {
            return false;
        }

        foreach ($this->requiredParts as $part) {
            if (!isset($url[$part])) {
                return false;
            }
        }

        return true;
    }
}
