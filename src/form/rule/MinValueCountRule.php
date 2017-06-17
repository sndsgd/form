<?php

namespace sndsgd\form\rule;

/**
 * Ensure a field has at least a certain number of values
 */
class MinValueCountRule extends RuleAbstract
{
    /**
     * The min number of values
     *
     * @var int
     */
    protected $minValues;

    /**
     * @param int $minValues
     */
    public function __construct(int $minValues)
    {
        if ($minValues < 1) {
            throw new \InvalidArgumentException(
                "invalid value provided for 'minValues'; ".
                "expecting an integer greater than or equal to 1"
            );
        }
        $this->minValues = $minValues;
    }

    /**
     * @inheritDoc
     */
    public function getDescription(): string
    {
        return sprintf(_("min-values:%s"), $this->minValues);
    }

    /**
     * @inheritDoc
     */
    public function getErrorMessage(): string
    {
        if ($this->errorMessage) {
            return sprintf($this->errorMessage, $this->minValues);
        }

        if ($this->minValues === 1) {
            return _("must be no less than 1 value");
        }

        return sprintf(
            _("must be no less than %s values"),
            $this->minValues
        );
    }

    /**
     * @inheritDoc
     */
    public function validate(
        &$value,
        \sndsgd\form\Validator $validator = null
    ): bool
    {
        $count = is_array($value) ? count($value) : 1;
        return ($count >= $this->minValues);
    }
}
