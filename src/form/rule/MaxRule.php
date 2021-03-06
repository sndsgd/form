<?php

namespace sndsgd\form\rule;

/**
 * Ensure a value is at least a given amount
 */
class MaxRule extends RuleAbstract
{
    /**
     * The max value
     *
     * @var int
     */
    protected $max;

    /**
     * @param int|float $max
     */
    public function __construct($max)
    {
        if (!is_integer($max) && !is_float($max)) {
            throw new \InvalidArgumentException(
                "invalid value provided for 'max'; ".
                "expecting an integer or a float"
            );
        }
        $this->max = $max;
    }

    /**
     * @inheritDoc
     */
    public function getDescription(): string
    {
        return sprintf(_("max:%s"), $this->max);
    }

    /**
     * @inheritDoc
     */
    public function getErrorMessage(): string
    {
        if ($this->errorMessage) {
            return sprintf($this->errorMessage, $this->max);
        }
        return sprintf(_("must be no greater than %s"), $this->max);
    }

    /**
     * @inheritDoc
     */
    public function validate(
        &$value,
        \sndsgd\form\Validator $validator = null
    ): bool
    {
        return (
            (is_int($value) || is_float($value)) &&
            $value <= $this->max
        );
    }
}
