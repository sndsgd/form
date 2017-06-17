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
     * @inheritDoc
     */
    public function getType(): string
    {
        return "object";
    }

    /**
     * @inheritDoc
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
     * @inheritDoc
     */
    public function getFieldRules(): array
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function getKeyRules(): array
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function getValueRules(): array
    {
        return [];
    }
}
