<?php

namespace sndsgd\form\field;

class FloatField extends ValueField
{
    public function __construct(string $name = "")
    {
        parent::__construct($name);
        $this->addRule(new \sndsgd\form\rule\FloatRule());
    }

    public function getType(): string
    {
        return "float";
    }
}
