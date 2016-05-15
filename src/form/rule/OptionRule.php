<?php

namespace sndsgd\form\rule;

/**
 * Ensure a value is in a map of acceptable values
 */
class OptionRule extends RuleAbstract
{
    /**
     * The available options
     *
     * @var array<string|int,mixed>
     */
    protected $options;

    /**
     * @param array<string,mixed>
     */
    public function __construct(array $options)
    {
        if (\sndsgd\Arr::isIndexed($options)) {
            $values = array_values($options);
            $options = array_combine($values, $values);
        }
        $this->options = array_change_key_case($options, CASE_LOWER);
    }

    /**
     * Get the available options wrapped in single quotes
     *
     * @return array<string>
     */
    private function getWrappedOptions()
    {
        $ret = [];
        foreach (array_keys($this->options) as $option) {
            $ret[] = var_export($option, true);
        }
        return $ret;
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription(): string
    {
        $opts = implode(",", $this->getWrappedOptions());
        return "in:[$opts]";
    }

    /**
     * {@inheritdoc}
     */
    public function getErrorMessage(): string
    {
        $opts = \sndsgd\Arr::implode(", ", $this->getWrappedOptions(), "or ");
        return "must be $opts";
    }

    /**
     * {@inheritdoc}
     */
    public function validate(
        &$value,
        \sndsgd\form\Validator $validator = null
    ): bool
    {
        if (!isset($this->options[$value])) {
            return false;
        }

        $value = $this->options[$value];
        return true;
    }
}
