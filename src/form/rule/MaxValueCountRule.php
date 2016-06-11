<?php

namespace sndsgd\form\rule;

/**
 * Ensure a field has no more than a certain number of values
 */
class MaxValueCountRule extends RuleAbstract
{
    /**
     * The max number of values
     *
     * @var int
     */
    protected $maxValues;

    /**
     * @param int $maxValues
     */
    public function __construct(int $maxValues)
    {
        if ($maxValues < 1) {
            throw new \InvalidArgumentException(
                "invalid value provided for 'maxValues'; ".
                "expecting an integer greater than or equal to 1"
            );
        }
        $this->maxValues = $maxValues;
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription(): string
    {
        return sprintf(_("max-values:%s"), $this->maxValues);
    }

    /**
     * {@inheritdoc}
     */
    public function getErrorMessage(): string
    {
        if ($this->errorMessage) {
            return sprintf($this->errorMessage, $this->maxValues);
        }

        if ($this->maxValues === 1) {
            return _("must be no more than 1 value");
        }

        return sprintf(
            _("must be no more than %s values"),
            $this->maxValues
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
        $count = is_array($value) ? count($value) : 1;
        return ($count <= $this->maxValues);
    }
}
