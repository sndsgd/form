<?php

namespace sndsgd\form\field;

class StringField extends ValueField
{
    public function getType(): string
    {
        return "string";
    }

    public function setDefaultValue($defaultValue): FieldInterface
    {
        if (!is_string($defaultValue)) {
            throw new \InvalidArgumentException("expecting a string");
        }

        $this->defaultValue = $defaultValue;
        return $this;
    }
}
