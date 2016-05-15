<?php

namespace sndsgd\form\detail;

use \sndsgd\form\field\FieldInterface;

abstract class DetailAbstract implements DetailInterface, \JsonSerializable
{
    /**
     * The field to extract details from
     *
     * @var \sndsgd\form\field\FieldInterface
     */
    protected $field;

    /**
     * @param \sndsgd\form\field\FieldInterface $field
     */
    public function __construct(FieldInterface $field)
    {
        $this->field = $field;
    }

    /**
     * Retreive a rules from a field
     *
     * @param \sndsgd\form\field\FieldInterface $field
     * @return array<string,string>
     */
    protected function getRulesFromField(FieldInterface $field): array
    {
        $ret = [];
        foreach ($field->getRules() as $rule) {
            $ret[] = [
                "description" => $rule->getDescription(),
                "errorMessage" => $rule->getErrorMessage(),
            ];
        }
        return $ret;
    }

    /**
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return [
            "name" => $this->field->getName(),
            "type" => $this->getType(),
            "signature" => $this->getSignature(),
            "description" => $this->field->getDescription(),
            "default" => $this->field->getDefaultValue(),
            "rules" => array_filter([
                "keys" => $this->getKeyRules(),
                "values" => array_merge(
                    $this->getValueRules(),
                    $this->getFieldRules()
                )
            ]),
        ];
    }

    /**
     * @return array<string,mixed>
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
