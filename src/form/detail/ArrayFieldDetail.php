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
        return "array<$valueType>";
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
