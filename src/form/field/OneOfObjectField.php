<?php

namespace sndsgd\form\field;

/**
 * A object field that uses the value of a given key to determine which
 * specific field to use for validation.
 */
class OneOfObjectField extends \sndsgd\form\field\ObjectField
{
    /**
     * The key that is used to determine which field to use for validation
     *
     * @var string
     */
    protected $key;

    /**
     * A map of key values and the the associated fields
     *
     * @var array<string,ObjectField>
     */
    protected $map = [];

    public function __construct(
        string $name,
        string $key,
        array $map
    )
    {
        parent::__construct($name);
        $this->key = $key;
        foreach ($map as $keyValue => $field) {
            if (!($field instanceof ObjectField)) {
                throw new \InvalidArgumentException(sprintf(
                    "invalid field provided for '%s'; expecting an '%s' instance",
                    $keyValue,
                    ObjectField::class
                ));
            }

            $this->map[$keyValue] = $field;
        }
    }

    public function validate($values, \sndsgd\form\Validator $validator)
    {
        if (!is_array($values)) {
            $validator->addError("must be an object");
            return false;
        }

        $keyValue = $values[$this->key] ?? null;
        if ($keyValue === null) {
            $validator->addError("required", $validator->getName($this->key));
            return false;
        }

        $field = $this->map[$keyValue] ?? null;
        if ($field === null) {
            $validator->addError($this->getValidValuesMessage(), $validator->getName($this->key));
            return false;
        }

        return $field->validate($values, $validator);
    }

    protected function getValidValuesMessage(): string
    {
        $values = [];
        foreach ($this->map as $key => $field) {
            $values[] = var_export($key, true);
        }

        switch (count($values)) {
            case 1:
                $options = $values[0];
                break;
            case 2:
                $options = implode(" or ", $values);
                break;
            default:
                $values[] = "or ".array_pop($values);
                $options = implode(", ", $values);
                break;
        }

        return "must be $options";
    }
}
