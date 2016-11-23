<?php

namespace sndsgd\form;

/**
 * An interface for a form validation error
 */
interface ErrorInterface
{
    /**
     * Get a human readable error message that describes the error encountered
     *
     * @return string
     */
    public function getMessage(): string;

    /**
     * Get the name of the field in which the error occured
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Export the error as an array
     *
     * @return array<string,string|int>
     */
    public function serialize(): array;
}
