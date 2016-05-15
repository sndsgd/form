<?php

namespace sndsgd\form\field;

use \sndsgd\form\rule\RuleInterface;

interface FieldInterface
{
    /**
     * The classname of the rule that validates a required value
     *
     * This can be used by \sndsgd\form\field\FieldInterface::validate to 
     * determine whether an empty value should be validated
     *
     * @var string
     */
    const REQUIRED = \sndsgd\form\rule\RequiredRule::class;

    /**
     * Get the field name
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Set a human readable description describing the field
     *
     * @param string $description
     * @return \sndsgd\form\field\FieldInterface
     */
    public function setDescription(string $description): FieldInterface;

    /**
     * Get the human readable description
     *
     * @return string
     */
    public function getDescription(): string;

    /**
     * Set the default value
     *
     * @param mixed $defaultValue
     * @return \sndsgd\form\field\FieldInterface
     */
    public function setDefaultValue($defaultValue): FieldInterface;

    /**
     * Get the default value
     *
     * @return mixed
     */
    public function getDefaultValue();

    /**
     * Add a validation rule to the field
     *
     * @param \sndsgd\form\rule\RuleInterface $rule
     * @return \sndsgd\form\field\FieldInterface
     */
    public function addRule(RuleInterface $rule): FieldInterface;

    /**
     * Add validation rules to the field
     *
     * @param \sndsgd\form\rule\RuleInterface ...$rules
     * @return \sndsgd\form\field\FieldInterface
     */
    public function addRules(RuleInterface ...$rules): FieldInterface;

    /**
     * Determine whether or not the field has a particular rule
     *
     * @param string $ruleName The name of the rule
     * @return bool
     */
    public function hasRule(string $ruleName): bool;

    /**
     * @return array<\sndsgd\form\rule\RuleInterface>
     */
    public function getRules(): array;

    /**
     * Retrieve information about the field for generating docs
     *
     * @return \sndsgd\form\detail\DetailInterface
     */
    public function getDetail(): \sndsgd\form\detail\DetailInterface;

    /**
     * Verify and update the values in the field
     *
     * @param mixed $values The value(s) to validate
     * @param \sndsgd\form\Validator $validator
     * @return mixed The validated field value(s)
     */
    public function validate($values, \sndsgd\form\Validator $validator);
}
