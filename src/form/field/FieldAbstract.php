<?php

namespace sndsgd\form\field;

use \sndsgd\form\rule\RuleInterface;

abstract class FieldAbstract implements FieldInterface
{
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
     * Get the name of the field
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
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
            throw new \sndsgd\form\DuplicateRuleException(
                "duplicate rule '$key' detected for '{$this->name}'"
            );
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
