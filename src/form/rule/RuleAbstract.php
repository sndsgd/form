<?php

namespace sndsgd\form\rule;

/**
 * A field validation and/or formatting rule
 */
abstract class RuleAbstract implements RuleInterface
{
    /**
     * Storage for a custom error message
     *
     * @var string
     */
    protected $errorMessage = "";

    /**
     * {@inheritdoc}
     */
    public function getClass(): string
    {
        return get_class($this);
    }

    /**
     * {@inheritdoc}
     */
    public function setErrorMessage(string $errorMessage): RuleInterface
    {
        $this->errorMessage = $errorMessage;
        return $this;
    }
}
