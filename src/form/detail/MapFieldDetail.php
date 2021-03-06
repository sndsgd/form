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
     * @inheritDoc
     */
    public function getType(): string
    {
        return "map";
    }

    /**
     * @inheritDoc
     */
    public function getSignature(): string
    {
        $rc = new \ReflectionClass($this->field);
        $property = $rc->getProperty("keyField");
        $property->setAccessible(true);

        $keyField = $property->getValue($this->field);
        $keyType = $keyField->getDetail()->getType();
        $valueType = $this->field->getValueField()->getDetail()->getSignature();
        return "map<$keyType,$valueType>";
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
        $keyRules = $this->getRulesFromField($this->field->getKeyField());
        return $this->filterRequiredRule($keyRules);
    }

    /**
     * @inheritDoc
     */
    public function getValueRules(): array
    {
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
