<?php

namespace sndsgd\form\field;

abstract class ParentFieldAbstract extends FieldAbstract
{
    protected $valueField;

    public function getValueField(): FieldInterface
    {
        return $this->valueField;
    }

    protected function validateCollection(
        string $expectType,
        $values,
        \sndsgd\form\Validator $validator
    ): bool
    {
        if (
            !$this->hasRule(FieldInterface::REQUIRED) &&
            (is_null($values) || is_array($values) && empty($values))
        ) {
            return false;
        }

        if (!is_array($values)) {
            $validator->addError(
                $this->getNestedName($validator->getOptions()->getNameDelimiter()),
                $this->getUnexpectedTypeMessage($expectType, $values)
            );
            return false;
        }

        # verify the parent field rules
        # these should never have any impact on the values, but should be
        # used to verify all given values are acceptable together
        foreach ($this->rules as $rule) {
            if (!$rule->validate($values, $validator)) {
                $validator->addError(
                    $this->getNestedName($validator->getOptions()->getNameDelimiter()),
                    $rule->getErrorMessage()
                );
                return false;
            }
        }

        return true;
    }

    protected function getUnexpectedTypeMessage(string $type, $value): string
    {
        $actualType = gettype($value);
        $word = in_array($actualType, ["integer", "object"]) ? "an" : "a";
        return "expecting a $type; encounted $word $actualType";
    }
}
