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
     * Whether to cast non array values to an array during validation
     *
     * @var bool
     */
    protected $isOneOrMore;

    /**
     * {@inhertidoc}
     */
    public function __construct(
        string $name,
        FieldInterface $valueField,
        bool $isOneOrMore = false
    )
    {
        if ($valueField instanceof ArrayField) {
            throw new \InvalidArgumentException(
                "unexpected value provided for 'valueField'; nesting ".
                "instances of ".__CLASS__." is not permitted"
            );
        }

        parent::__construct($name);
        $this->valueField = $valueField->setParent($this);
        $this->isOneOrMore = $isOneOrMore;
        $this->defaultValue = [];
    }

    /**
     * Determine whether validation allows for casting a value into an array
     *
     * @return bool
     */
    public function isOneOrMore(): bool
    {
        return $this->isOneOrMore;
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
     * @inheritDoc
     */
    public function validate($values, \sndsgd\form\Validator $validator)
    {
        if ($this->isOneOrMore && !is_array($values)) {
            $values = (array) $values;
        }

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
     * @inheritDoc
     */
    public function getDetail(): \sndsgd\form\detail\DetailInterface
    {
        return new \sndsgd\form\detail\ArrayFieldDetail($this);
    }
}
