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
     * @inheritDoc
     */
    public function getDescription(): string
    {
        return sprintf(_("min-length:%s"), number_format($this->minLength));
    }

    /**
     * @inheritDoc
     */
    public function getErrorMessage(): string
    {
        if ($this->errorMessage) {
            return sprintf($this->errorMessage, $this->minLength);
        }

        if ($this->minLength === 1) {
            return _("must be at least 1 character");
        }

        return sprintf(
            _("must be at least %s characters"),
            number_format($this->minLength)
        );
    }

    /**
     * @inheritDoc
     */
    public function validate($value, \sndsgd\form\Validator $validator = null)
    {
        if (strlen($value) < $this->minLength) {
            throw new \sndsgd\form\RuleException($this->getErrorMessage());
        }

        return $value;
    }
}
