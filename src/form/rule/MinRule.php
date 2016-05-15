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
     * {@inheritdoc}
     */
    public function getDescription(): string
    {
        return "min:{$this->min}";
    }

    /**
     * {@inheritdoc}
     */
    public function getErrorMessage(): string
    {
        return "must be at least {$this->min}";
    }

    /**
     * {@inheritdoc}
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
