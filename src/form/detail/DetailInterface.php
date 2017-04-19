<?php

namespace sndsgd\form\detail;

/**
 * A field wrapper used to extract information for docs
 */
interface DetailInterface
{
    /**
     * Get the field type
     *
     * @return string
     */
    public function getType(): string;

    /**
     * Get the field signature
     *
     * Examples:
     *  string, int, float, bool - Simple scalar values
     *  array<int> - An array of integers
     *  object<string,string> - An object with string keys and string values
     *  object<string,array<int>> - An object with string keys and integer array values
     *
     * @return string
     */
    public function getSignature(): string;

    /**
     * Get all the rules that are used to validate multiple values
     *
     * @return array
     */
    public function getFieldRules(): array;

    /**
     * Get all rules that will be used for value validation
     *
     * @return array<\sndsgd\form\rule\RuleInterface>
     */
    public function getValueRules(): array;

    /**
     * Create an array representation of the field
     *
     * @return array<string,mixed>
     */
    public function toArray(): array;
}
