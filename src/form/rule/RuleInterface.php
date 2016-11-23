<?php

namespace sndsgd\form\rule;

/**
 * An interface for a validation rule
 *
 * Implementations can be used to determine if a value is valid, and
 * optionally to update the value to meet typee constraints
 */
interface RuleInterface
{
    /**
     * Get the rule classname
     * Used to determine if the rule is already registered in a collection
     *
     * @return string
     */
    public function getClass(): string;

    /**
     * Get a short description of the field for use in docs
     *
     * @return string
     */
    public function getDescription(): string;

    /**
     * Set a custom validation error message
     *
     * @param string $errorMessage
     * @return \sndsgd\form\rule\RuleInterface
     */
    public function setErrorMessage(string $errorMessage): RuleInterface;

    /**
     * Get the error message
     *
     * @return string
     */
    public function getErrorMessage(): string;

    /**
     * @param mixed $value The value to validate
     * @param \sndsgd\form\Validator $validator
     * @return bool
     */
    public function validate(&$value, \sndsgd\form\Validator $validator = null): bool;
}
