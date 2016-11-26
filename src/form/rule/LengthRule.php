<?php

namespace sndsgd\form\rule;

/**
 * Ensure a value is a certain number of characters
 */
class LengthRule extends RuleAbstract
{
    /**
     * The valid string length
     *
     * @var int
     */
    protected $length;

    /**
     * @param int $length
     */
    public function __construct(int $length)
    {
        if ($length < 1) {
            throw new \InvalidArgumentException(
                "invalid value provided for 'length'; ".
                "expecting an integer greater than or equal to 1"
            );
        }
        $this->length = $length;
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription(): string
    {
        return sprintf(_("length:%s"), number_format($this->length));
    }

    /**
     * {@inheritdoc}
     */
    public function getErrorMessage(): string
    {
        if ($this->errorMessage) {
            return sprintf($this->errorMessage, $this->length);
        }

        if ($this->length === 1) {
            return _("must be 1 character");
        }

        return sprintf(
            _("must be %s characters"),
            number_format($this->length)
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
        return (strlen($value) === $this->length);
    }
}
