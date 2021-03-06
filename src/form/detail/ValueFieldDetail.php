<?php

namespace sndsgd\form\detail;

use \sndsgd\form\rule;

class ValueFieldDetail extends DetailAbstract
{
    /**
     * @inheritDoc
     */
    public function getType(): string
    {
        $type = $this->field->getType();
        if ($type !== "") {
            return $type;
        }

        $rules = [
            rule\BooleanRule::class => "bool",
            rule\FloatRule::class => "float",
            rule\IntegerRule::class => "int",
            rule\NumericRule::class => "float",
        ];

        foreach ($rules as $rule => $type) {
            if ($this->field->hasRule($rule)) {
                return $type;
            }
        }

        return "string";
    }

    /**
     * @inheritDoc
     */
    public function getSignature(): string
    {
        return $this->getType();
    }

    /**
     * @inheritDoc
     */
    public function getFieldRules(): array
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function getKeyRules(): array
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function getValueRules(): array
    {
        return $this->getRulesFromField($this->field);
    }
}
