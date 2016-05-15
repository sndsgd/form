<?php

namespace sndsgd\form\rule;

/**
 * Ensure a value is at least a certain number of characters
 */
class MinLengthRule extends RuleAbstract
{
    /**
     * The min string length
     *
     * @var int
     */
    protected $minLength;

    /**
     * @param int $minLength
     */
    public function __construct(int $minLength)
    {
        if ($minLength < 1) {
            throw new \InvalidArgumentException(
                "invalid value provided for 'minLength'; ".
                "expecting an integer greater than or equal to 1"
            );
        }
        $this->minLength = $minLength;
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription(): string
    {
        return "min-length:".number_format($this->minLength);
    }

    /**
     * {@inheritdoc}
     */
    public function getErrorMessage(): string
    {
        if ($this->minLength === 1) {
            return "must be at least 1 character";
        }

        $length = number_format($this->minLength);
        return "must be at least $length characters";
    }

    /**
     * {@inheritdoc}
     */
    public function validate(
        &$value,
        \sndsgd\form\Validator $validator = null
    ): bool
    {
        return (strlen($value) >= $this->minLength);
    }
}
