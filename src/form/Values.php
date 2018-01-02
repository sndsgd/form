<?php

namespace sndsgd\form;

class Values
{
    protected $values;

    public function __construct(array $values)
    {
        $this->values = $values;
    }

    public function get(string $name)
    {
        $search = &$this->values;
        $parts = explode(".", $name);
        foreach ($parts as $name) {
            if (!isset($search[$name])) {
                return null;
            }

            $search = &$search[$name];
        }

        return $search;
    }

    public function getRelative(string $name, string $relativeName)
    {
        $nameParts = explode(".", $name);
        $relativeParts = explode(".", $relativeName);

        foreach ($relativeParts as $name) {
            if ($name === "") {
                if (array_pop($nameParts) === null) {
                    throw new \Exception("failed to traverse up past root");
                }
            } else {
                $nameParts[] = $name;
            }
        }

        return $this->get(implode(".", $nameParts));
    }
}
