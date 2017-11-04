<?php

namespace sndsgd\form\detail;

class ArrayFieldDetail extends DetailAbstract
{
    /**
     * @param \sndsgd\form\field\ArrayField $field
     */
    public function __construct(\sndsgd\form\field\ArrayField $field)
    {
        $this->field = $field;
    }

    /**
     * @inheritDoc
     */
    public function getType(): string
    {
        return "array";
    }

    /**
     * @inheritDoc
     */
    public function getSignature(): string
    {
        $valueType = $this->field->getValueField()->getDetail()->getSignature();

        # this currently is not allowed because nested arrays aren't allowed
        # wrap union types in parens
        # if (strpos($valueType, "|") !== false) {
        #     $valueType = "($valueType)";
        # }

        $arraySignature = "array<$valueType>";
        if (!$this->field->isOneOrMore()) {
            return $arraySignature;
        }

        return "$valueType|$arraySignature";
    }

    /**
     * @inheritDoc
     */
    public function getFieldRules(): array
    {
        return $this->getRulesFromField($this->field);
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
        return $this->getRulesFromField($this->field->getValueField());
    }
}
