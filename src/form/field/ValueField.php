<?php

namespace sndsgd\form\field;

class ValueField extends FieldAbstract
{
    /**
     * The human readable type of the field
     *
     * @var string
     */
    protected $type = "";

    /**
     * @param string $type
     */
    public function setType(string $type): FieldInterface
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Set the default value for the field
     *
     * @param mixed $defaultValue A scalar value
     * @return \sndsgd\form\field\ValueField
     * @throws \InvalidArgumentException
     */
    public function setDefaultValue($defaultValue): FieldInterface
    {
        if (!is_scalar($defaultValue) && !is_null($defaultValue)) {
            throw new \InvalidArgumentException(
                "invalid value provided for 'defaultValue'; ".
                "expecting either a scalar or null value"
            );
        }
        $this->defaultValue = $defaultValue;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function validate($values, \sndsgd\form\Validator $validator)
    {
        if (is_array($values)) {
            $len = count($values);
            if ($len > 1) {
                $validator->addError(
                    $this->getNestedName($validator->getNameDelimiter()),
                    "expecting a single value; encountered $len"
                );
                return null;
            }
            $values = $values[0];
        }

        if (
            is_null($values) &&
            !$this->hasRule(\sndsgd\form\rule\RequiredRule::class)
        ) {
            return $this->defaultValue;
        }

        foreach ($this->rules as $rule) {
            if (!$rule->validate($values, $validator)) {
                $validator->addError(
                    $this->getNestedName($validator->getNameDelimiter()),
                    $rule->getErrorMessage()
                );
                return null;
            }
        }

        return $values;
    }

    /**
     * {@inheritdoc}
     */
    public function getDetail(): \sndsgd\form\detail\DetailInterface
    {
        return new \sndsgd\form\detail\ValueFieldDetail($this);
    }
}
