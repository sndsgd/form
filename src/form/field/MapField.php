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
        $this->keyField = $keyField;
        $this->valueField = $valueField;
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
        try {
            $values = $this->validateCollection("map", $values, $validator);
        } catch (\sndsgd\form\RuleException $ex) {
            $validator->addError($ex->getClientMessage());
            return [];
        }

        # validate each value pair
        $ret = [];
        foreach ($values as $key => $value) {
            $validator->appendName($key);

            try {
                $isKey = true;
                $key = $this->keyField->validate($key, $validator);
                $isKey = false;
                $value = $this->valueField->validate($value, $validator);
                $ret[$key] = $value;
            } catch (\sndsgd\form\RuleException $ex) {
                $prefix = $isKey ? "invalid key; " : "";
                $validator->addError($prefix.$ex->getClientMessage());

                # @todo make this the empty version of the valueField type
                $ret[$key] = null;
            }

            $validator->popName();
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
