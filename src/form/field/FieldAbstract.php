<?php

namespace sndsgd\form\field;

use \sndsgd\form\rule\RuleInterface;

abstract class FieldAbstract implements FieldInterface
{
    /**
     * A field may be the child of another field
     *
     * @var \sndsgd\form\field\FieldInterface
     */
    protected $parent;

    /**
     * The name of the field
     * 
     * @var string
     */
    protected $name = "";

    /**
     * A description of the expected value(s)
     *
     * @var string
     */
    protected $description = "";

    /**
     * 
     * @var array<string,\sndsgd\form\rule\RuleInterface>
     */
    protected $rules = [];

    /**
     * A value to use if none is provided
     *
     * @var mixed
     */
    protected $defaultValue = null;

    public function __construct(string $name = "")
    {
        $this->name = $name;
    }

    /**
     * Set the name of the field
     * Allows parent fields to update the name before validating
     *
     * @param string $name
     */
    public function setName(string $name = ""): FieldInterface
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get the name of the field
     *
     * @param array<string> $keys The nested names of parents
     * @param string $delimiter A string to use when joining the name
     * @return string
     */
    public function getName(array $keys = [], string $delimiter = "."): string
    {
        if (empty($keys)) {
            return $this->name;
        }

        $keys[] = $this->name;
        return implode($delimiter, $keys);
    }

    /**
     * Get a field's nested name
     * 
     * @param string $delimiter
     * @param string $name A name to append to the result
     * @return string
     */
    public function getNestedName(
        string $delimiter = ".",
        string $name = ""
    ): string
    {
        $keys = array_filter([$this->name, $name], "strlen");
        $parent = $this;
        while ($parent = $parent->getParent()) {
            $name = $parent->getName();
            if ($name) {
                array_unshift($keys, $parent->getName());    
            }
        }
        return implode($delimiter, $keys);
    }

    public function setDescription(string $description): FieldInterface
    {
        $this->description = $description;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setParent(FieldInterface $field): FieldInterface
    {
        $this->parent = $field;
        return $this;
    }

    /**
     * @return \sndsgd\form\field\FieldInterface|null
     */
    public function getParent()
    {
        return $this->parent;
    }

    public function setDefaultValue($defaultValue): FieldInterface
    {
        $this->defaultValue = $defaultValue;
        return $this;
    }

    public function getDefaultValue()
    {
        return $this->defaultValue;
    }

    public function addRule(RuleInterface $rule): FieldInterface
    {
        $key = $rule->getClass();
        if (isset($this->rules[$key])) {
            throw new \sndsgd\form\DuplicateRuleException($key);
        }

        # the required rule should always be first
        if ($key === \sndsgd\form\rule\RequiredRule::class) {
            $this->rules = [$key => $rule] + $this->rules;
        } else {
            $this->rules[$key] = $rule;
        }

        return $this;
    }

    public function addRules(RuleInterface ...$rules): FieldInterface
    {
        foreach ($rules as $rule) {
            $this->addRule($rule);
        }
        return $this;
    }

    public function hasRule(string $ruleName): bool
    {
        return isset($this->rules[$ruleName]);
    }

    public function getRules(): array
    {
        return $this->rules;
    }

    public function removeRules(string ...$rules): FieldInterface
    {
        foreach ($rules as $rule) {
            unset($this->rules[$rule]);
        }
        return $this;
    }
}
