<?php

namespace sndsgd\form\field;

class BooleanField extends ValueField
{
    public function __construct(string $name = "")
    {
        parent::__construct($name);
        $this->addRule(new \sndsgd\form\rule\BooleanRule());
    }

    public function getType(): string
    {
        return "boolean";
    }

    public function setDefaultValue($defaultValue): FieldInterface
    {
        if (!is_bool($defaultValue)) {
            throw new \InvalidArgumentException("expecting a boolean");
        }

        $this->defaultValue = $defaultValue;
        return $this;
    }
}
