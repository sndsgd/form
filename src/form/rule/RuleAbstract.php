<?php

namespace sndsgd\form\rule;

/**
 * A field validation and/or formatting rule
 */
abstract class RuleAbstract implements RuleInterface
{
    /**
     * A short description of what the rule does
     *
     * @var string
     */
    protected $description = "value";

    /**
     * The error message when validation fails
     * 
     * @var string
     */
    protected $errorMessage = "invalid value";

    /**
     * {@inheritdoc}
     */
    public function getClass(): string
    {
        return get_called_class();
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * {@inheritdoc}
     */
    public function setErrorMessage(string $errorMessage): RuleInterface
    {
        $this->errorMessage = $errorMessage;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }
}
