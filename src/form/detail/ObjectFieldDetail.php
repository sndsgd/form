<?php

namespace sndsgd\form\detail;

class ObjectFieldDetail extends DetailAbstract
{
    /**
     * @param \sndsgd\form\field\ObjectField $field
     */
    public function __construct(\sndsgd\form\field\ObjectField $field)
    {
        $this->field = $field;
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return "object";
    }

    /**
     * {@inheritdoc}
     */
    public function getSignature(): string
    {
        $types = [];
        foreach ($this->field->getFields() as $name => $field) {
            $type = $field->getDetail()->getSignature();
            $types[$type] = true;
        }
        $types = implode("|", array_keys($types));

        return "object<string,$types>";
    }

    public function toArray(): array
    {
        $ret = [];
        foreach ($this->field->getFields() as $name => $field) {
            $ret[] = $field->getDetail()->toArray();
        }

        # if the field has a name 
        $name = $this->field->getName();
        if (!empty($name)) {
            $ret = [
                "name" => $name,
                "type" => $this->getType(),
                "signature" => $this->getSignature(),
                "description" => $this->field->getDescription(),
                "fields" => $ret,
            ];
        }

        return $ret;
    }

    /**
     * {@inheritdoc}
     */
    public function getFieldRules(): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getKeyRules(): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getValueRules(): array
    {
        return [];
    }
}
