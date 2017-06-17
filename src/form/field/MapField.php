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

    public function __construct(
        string $name,
        ValueField $keyField,
        FieldInterface $valueField
    )
    {
        parent::__construct($name);
        $this->keyField = $keyField->setParent($this);
        $this->valueField = $valueField->setParent($this);
    }

    /**
     * Get the key field
     *
     * @return \sndsgd\form\field\ValueField
     */
    public function getKeyField(): ValueField
    {
        return $this->keyField;
    }

    /**
     * @inheritDoc
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
     * @inheritDoc
     */
    public function getDetail(): \sndsgd\form\detail\DetailInterface
    {
        return new \sndsgd\form\detail\MapFieldDetail($this);
    }
}
