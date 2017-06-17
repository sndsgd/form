<?php

namespace sndsgd\form\rule;

/**
 * Ensure a value is at least a given amount
 */
class MinRule extends RuleAbstract
{
    /**
     * The min value
     *
     * @var int
     */
    protected $min;

    /**
     * @param int|float $min
     */
    public function __construct($min)
    {
        if (!is_integer($min) && !is_float($min)) {
            throw new \InvalidArgumentException(
                "invalid value provided for 'min'; ".
                "expecting an integer or a float"
            );
        }
        $this->min = $min;
    }

    /**
     * @inheritDoc
     */
    public function getDescription(): string
    {
        return sprintf(_("min:%s"), $this->min);
    }

    /**
     * @inheritDoc
     */
    public function getErrorMessage(): string
    {
        if ($this->errorMessage) {
            return sprintf($this->errorMessage, $this->min);
        }
        return sprintf(_("must be at least %s"), $this->min);
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
            $value >= $this->min
        );
    }
}
