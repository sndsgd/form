<?php

namespace sndsgd\form\field;

/**
 * A field for an indexed array of values
 */
class ArrayField extends ParentFieldAbstract
{
    /**
     * @var \sndsgd\form\field\FieldInterface
     */
    protected $valueField;

    /**
     * {@inhertidoc}
     */
    public function __construct(string $name = "")
    {
        parent::__construct($name);
        $this->defaultValue = [];
    }

    /**
     * Set the default value
     *
     * @param array $defaultValue
     * @return \sndsgd\form\field\FieldInterface
     * @throws \InvalidArgumentException
     */
    public function setDefaultValue($defaultValue): FieldInterface
    {
        if (!is_array($defaultValue)) {
            throw new \InvalidArgumentException(
                "The default value for instances of ".
                __CLASS__." must be an array"
            );
        }

        $this->defaultValue = $defaultValue;
        return $this;
    }

    /**
     * Set the field that is used process each value in the array
     *
     * @param \sndsgd\form\field\FieldInterface $field
     * @throws \InvalidArgumentException If `$field` is an ArrayField
     */
    public function setValueField(FieldInterface $field): ArrayField
    {
        if ($field instanceof ArrayField) {
            throw new \InvalidArgumentException(
                "unexpected value provided for 'field'; nesting instances ".
                "of ".__CLASS__." in not permitted"
            );
        }

        $this->valueField = $field->setParent($this);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function validate($values, \sndsgd\form\Validator $validator)
    {
        if (!$this->validateCollection("array", $values, $validator)) {
            return [];
        }

        $ret = [];
        foreach (array_values($values) as $index => $value) {
            $result = $this->valueField
                ->setName($index)
                ->validate($value, $validator);

            if (!is_null($result)) {
                $ret[] = $result;
            }
        }

        return $ret;
    }

    /**
     * {@inheritdoc}
     */
    public function getDetail(): \sndsgd\form\detail\DetailInterface
    {
        return new \sndsgd\form\detail\ArrayFieldDetail($this);
    }
}
