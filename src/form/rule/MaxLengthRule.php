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
        return sprintf(_("max-length:%s"), number_format($this->maxLength));
    }

    /**
     * {@inheritdoc}
     */
    public function getErrorMessage(): string
    {
        if ($this->errorMessage) {
            return sprintf($this->errorMessage, $this->maxLength);
        }

        if ($this->maxLength === 1) {
            return _("must be no more than 1 character");
        }

        return sprintf(
            _("must be no more than %s characters"),
            number_format($this->maxLength)
        );
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
