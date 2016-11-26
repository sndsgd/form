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
     * {@inheritdoc}
     */
    public function getDescription(): string
    {
        if ($this->format === "") {
            return sprintf(_("datetime"));
        }

        return sprintf(_("datetime:%s"), $this->format);
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function validate(
        &$value,
        \sndsgd\form\Validator $validator = null
    ): bool
    {
        if ($this->format === "") {
            try {
                $date = new \DateTime($value);
                $value = $date;
                return true;
            } catch (\Exception $ex) {
                echo $ex->getMessage();
                return false;
            }
        }

        $date = \DateTime::createFromFormat($this->format, $value);
        if (!$date || $date->format($this->format) !== $value) {
            return false;
        }

        $value = $date;
        return true;
    }
}
