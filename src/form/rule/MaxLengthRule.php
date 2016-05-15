<?php

namespace sndsgd\form\rule;

/**
 * Ensure a value is at least a certain number or characters
 */
class MaxLengthRule extends RuleAbstract
{
    /**
     * The max string length
     *
     * @var int
     */
    protected $maxLength;

    /**
     * @param int $maxLength
     */
    public function __construct(int $maxLength)
    {
        if ($maxLength < 1) {
            throw new \InvalidArgumentException(
                "invalid value provided for 'maxLength'; ".
                "expecting an integer greater than or equal to 1"
            );
        }
        $this->maxLength = $maxLength;
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription(): string
    {
        return "max-length:".number_format($this->maxLength);
    }

    /**
     * {@inheritdoc}
     */
    public function getErrorMessage(): string
    {
        if ($this->maxLength === 1) {
            return "must be no more than 1 character";
        }

        $length = number_format($this->maxLength);
        return "must be no more than $length characters"; 
    }

    /**
     * {@inheritdoc}
     */
    public function validate(
        &$value,
        \sndsgd\form\Validator $validator = null
    ): bool
    {
        return (strlen($value) <= $this->maxLength);
    }
}
