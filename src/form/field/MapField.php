<?php

namespace sndsgd\form\field;

/**
 * A field for a map of values with user definable keys
 */
class MapField extends ParentFieldAbstract
{
    /**
     * The field used to validate map keys
     *
     * @var \sndsgd\field\ValueField
     */
    protected $keyField;

    /**
     * The field used to validate map values
     *
     * @var \sndsgd\field\FieldInterface
     */
    protected $valueField;

    /**
     * Set the field for the map keys
     *
     * @param \sndsgd\form\field\ValueField $keyField
     */
    public function setKeyField(ValueField $keyField): MapField
    {
        $this->keyField = $keyField->setParent($this);
        return $this;
    }

    public function getKeyField(): ValueField
    {
        return $this->keyField;
    }

    /**
     * Set the field for the map values
     *
     * @param \sndsgd\field\FieldInterface $valueField
     */
    public function setValueField(FieldInterface $valueField): MapField
    {
        $this->valueField = $valueField->setParent($this);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function validate($values, \sndsgd\form\Validator $validator)
    {
        if (!$this->validateCollection("map", $values, $validator)) {
            return [];
        }

        # validate each value pair
        $ret = [];
        foreach ($values as $key => $value) {

            $key = $this->keyField
                ->setName($key)
                ->validate($key, $validator);

            if ($key === null) {
                continue;
            }

            $value = $this->valueField
                ->setName($key)
                ->validate($value, $validator);

            if ($value !== null) {
                $ret[$key] = $value;
            }
        }

        return $ret;
    }

    /**
     * {@inheritdoc}
     */
    public function getDetail(): \sndsgd\form\detail\DetailInterface
    {
        return new \sndsgd\form\detail\MapFieldDetail($this);
    }
}
