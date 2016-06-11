<?php

namespace sndsgd\form\rule;

/**
 * Ensure a value matches a regex pattern
 */
class RegexRule extends RuleAbstract
{
    /**
     * The regex to match against values
     * 
     * @var string
     */
    protected $regex;

    /**
     * @param string $regex The regex to use in validation
     */
    public function __construct(string $regex)
    {
        if (@preg_match($regex, null) === false) {
            throw new \InvalidArgumentException(
                "invalid value provided for 'value'; ".
                "expecting a valid regex as string"
            );
        }
        $this->regex = $regex;
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription(): string
    {
        return sprintf(_("regex:%s"), $this->regex);
    }

    /**
     * {@inheritdoc}
     */
    public function getErrorMessage(): string
    {
        if ($this->errorMessage) {
            return sprintf($this->errorMessage, $this->regex);
        }
        return sprintf(_("must match regex pattern"), $this->regex);
    }

    /**
     * {@inheritdoc}
     */
    public function validate(
        &$value,
        \sndsgd\form\Validator $validator = null
    ): bool
    {
        return preg_match($this->regex, $value) === 1;
    }
}
