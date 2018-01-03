<?php

namespace sndsgd\form\field;

/**
 * A field for a map of values with predefined keys
 */
class ObjectField extends FieldAbstract
{
    /**
     * The child fields
     *
     * @var array<string,\sndsgd\form\field\FieldInterface>
     */
    protected $fields = [];

    public function addFields(FieldInterface ...$fields): ObjectField
    {
        foreach ($fields as $field) {
            $name = $field->getName();
            if ($this->hasField($name)) {
                throw new \sndsgd\form\DuplicateFieldException(
                    "failed to add field; '$name' is already defined"
                );
            }
            $this->fields[$name] = $field;
        }
        return $this;
    }

    public function hasField(string $name): bool
    {
        return isset($this->fields[$name]);
    }

    public function getField(string $name): FieldInterface
    {
        if (!$this->hasField($name)) {
            throw new \sndsgd\form\UnknownFieldException(
                "failed to get field; '$name' does not exist"
            );
        }

        return $this->fields[$name];
    }

    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * @inheritDoc
     */
    public function validate($values, \sndsgd\form\Validator $validator)
    {
        $ret = [];
        foreach ($this->fields as $name => $field) {
            $validator->appendName($name);
            if (isset($values[$name])) {
                $value = $values[$name];
                unset($values[$name]);
            } else {
                $value = $field->getDefaultValue();
            }

            $ret[$name] = $field->validate($value, $validator);
            $validator->popName();
        }

        # create unknown field errors for the remaining fields
        if (!$validator->getOptions()->getAllowUnknownFields() && !empty($values)) {
            foreach ($values as $name => $vals) {
                $validator->addError(
                    "unknown field",
                    $validator->getName($name)
                );
            }
        }

        return $ret;
    }

    /**
     * @inheritDoc
     */
    public function getDetail(): \sndsgd\form\detail\DetailInterface
    {
        return new \sndsgd\form\detail\ObjectFieldDetail($this);
    }
}
