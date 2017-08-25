<?php

namespace sndsgd;

class Form extends \sndsgd\form\field\ObjectField
{
    /**
     * Forms cannot have names
     * If they do it'll mess up nested naming structures
     *
     * @inheritDoc
     */
    public function __construct(string $name = "")
    {
        if ($name !== "") {
            throw new \InvalidArgumentException(
                "invalid value provided for 'name'; expecting an empty string"
            );
        }
        $this->name = "";
    }

    /**
     * Merge the fields of one or more forms into this one
     *
     * @param \sndsgd\Form $forms The forms to merge
     * @return \sndsgd\Form
     */
    public function merge(\sndsgd\Form ...$forms): Form
    {
        foreach ($forms as $form) {
            $fields = array_values($form->getFields());
            $this->addFields(...$fields);
        }

        return $this;
    }
}
