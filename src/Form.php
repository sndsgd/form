<?php

namespace sndsgd;

class Form extends \sndsgd\form\field\ObjectField
{
    /**
     * Forms cannot have names
     * If they do it'll mess up nested naming structures
     * 
     * {@inheritdoc}
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
}
