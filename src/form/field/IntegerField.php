<?php

namespace sndsgd\form\field;

class IntegerField extends ValueField
{
    public function __construct(string $name = "")
    {
        parent::__construct($name);
        $this->addRule(new \sndsgd\form\rule\IntegerRule());
    }

    public function getType(): string
    {
        return "integer";
    }

    public function setDefaultValue($defaultValue): FieldInterface
    {
        if (!is_int($defaultValue)) {
            throw new \InvalidArgumentException("expecting an integer");
        }

        $this->defaultValue = $defaultValue;
        return $this;
    }
}
