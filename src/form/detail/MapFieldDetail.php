<?php

namespace sndsgd\form\detail;

class MapFieldDetail extends DetailAbstract
{
    /**
     * @param \sndsgd\form\field\MapField $field
     */
    public function __construct(\sndsgd\form\field\MapField $field)
    {
        $this->field = $field;
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return "map";
    }

    /**
     * {@inheritdoc}
     */
    public function getSignature(): string
    {
        $rc = new \ReflectionClass($this->field);
        $property = $rc->getProperty("keyField");
        $property->setAccessible(true);

        $keyField = $property->getValue($this->field);
        $keyType = $keyfield->getDetail()->getType();
        $valueType = $this->field->getValueField()->getDetail()->getType();
        return "map<$keyType,$valueType>";
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
        $keyRules = $this->getRulesFromField($this->field->getKeyField());
        return $this->filterRequiredRule($keyRules);
    }

    /**
     * {@inheritdoc}
     */
    public function getValueRules(): array
    {
        $valueRules = $this->getRulesFromField($this->field->getValueField());
        $valueRules = $this->field->getValueField()->getDetail()->getValueRules();
        return $this->filterRequiredRule($valueRules);
    }

    private function filterRequiredRule(array $rules): array
    {
        $ret = [];
        foreach ($rules as $rule) {
            if ($rule["description"] === "required") {
                continue;
            }
            $ret[] = $rule;
        }
        return $ret;
    }
}
