<?php

namespace sndsgd\form\rule;

/**
 * Ensure a value is a valid date time
 */
class DateTimeRule extends RuleAbstract
{
    /**
     * The expected date format
     *
     * @var string
     */
    protected $format;

    /**
     * @param string $format
     */
    public function __construct(string $format = "")
    {
        $this->format = $format;
    }

    /**
     * @inheritDoc
     */
    public function getDescription(): string
    {
        if ($this->format === "") {
            return sprintf(_("datetime"));
        }

        return sprintf(_("datetime:%s"), $this->format);
    }

    /**
     * @inheritDoc
     */
    public function getErrorMessage(): string
    {
        if ($this->errorMessage) {
            return sprintf($this->errorMessage, $this->format);
        }

        if ($this->format === "") {
            return _("must be a valid datetime");
        }

        return sprintf(
            _("must be a valid datetime of the format '%s'"),
            $this->format
        );
    }

    /**
     * @inheritDoc
     */
    public function validate($value, \sndsgd\form\Validator $validator = null)
    {
        if ($this->format === "") {
            try {
                return new \DateTime($value);
            } catch (\Exception $ex) {
                # Failed to parse time string (#$%^&*) at position 0 (#): Unexpected character
                throw new \sndsgd\form\RuleException($this->getErrorMessage());
            }
        }

        $date = \DateTime::createFromFormat($this->format, $value);
        if (!$date || $date->format($this->format) !== $value) {
            throw new \sndsgd\form\RuleException($this->getErrorMessage());
        }

        return $date;
    }
}
