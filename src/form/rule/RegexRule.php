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
    public function __construct(
        string $regex,
        string $errorMessage
    )
    {
        if (@preg_match($regex, null) === false) {
            throw new \InvalidArgumentException(
                "invalid value provided for 'value'; ".
                "expecting a valid regex as string"
            );
        }
        $this->regex = $regex;
        $this->errorMessage = $errorMessage;
    }

    /**
     * @inheritDoc
     */
    public function getDescription(): string
    {
        return sprintf(_("regex:%s"), $this->regex);
    }

    /**
     * @inheritDoc
     */
    public function getErrorMessage(): string
    {
        if ($this->errorMessage) {
            return sprintf($this->errorMessage, $this->regex);
        }
        return sprintf(_("must match regex pattern"), $this->regex);
    }

    /**
     * @inheritDoc
     */
    public function validate($value, \sndsgd\form\Validator $validator = null)
    {
        if (preg_match($this->regex, $value) !== 1) {
            throw new \sndsgd\form\RuleException($this->getErrorMessage());
        }

        return $value;
    }

    /**
     * A boolean function for testing values
     *
     * @param [type] $value [description]
     * @param \sndsgd\form\Validator|null $validator [description]
     * @return bool
     */
    public function isValid(
        $value,
        \sndsgd\form\Validator $validator = null
    ): bool
    {
        try {
            $this->verify($value, $validator);
            return true;
        } catch (\sndsgd\form\RuleException $ex) {
            return false;
        }
    }

    public function verify($value, $validator)
    {
        if (!is_string($value)) {
            throw new \sndsgd\form\RuleException("expecting a string");
        }

        if (preg_match($this->regex, $value) !== 1) {
            throw new \sndsgd\form\RuleException($this->errorMessage);
        }

        return $value;
    }
}
