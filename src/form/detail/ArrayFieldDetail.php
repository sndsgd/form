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
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return "array";
    }

    /**
     * {@inheritdoc}
     */
    public function getSignature(): string
    {
        $valueType = $this->field->getValueField()->getDetail()->getType();
        return "array<$valueType>";
    }

    /**
     * {@inheritdoc}
     */
    public function getFieldRules(): array
    {
        return $this->getRulesFromField($this->field);
    }

    /**
     * {@inheritdoc}
     */
    public function getKeyRules(): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getValueRules(): array
    {
        return $this->getRulesFromField($this->field->getValueField());
    }
}
