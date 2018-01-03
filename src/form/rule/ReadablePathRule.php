<?php

namespace sndsgd\form\rule;

class ReadablePathRule extends \sndsgd\form\rule\RuleAbstract
{
    protected $isDirectory;

    public function __construct(bool $isDirectory = false)
    {
        $this->isDirectory = $isDirectory;
    }

    public function getDescription(): string
    {
        return ($this->isDirectory)
            ? _("readable directory path")
            : _("readable file path");
    }

    public function getErrorMessage(): string
    {
        return ($this->isDirectory)
            ? _("must be a readable directory path")
            : _("must be a readable file path");
    }

    public function validate($value, \sndsgd\form\Validator $validator = null)
    {
        if ($value instanceof \sndsgd\fs\entity\EntityInterface) {
            $entity = $value;
        } elseif ($this->isDirectory) {
            $entity = \sndsgd\Fs::dir($value);
        } else {
            $entity = \sndsgd\Fs::file($value);
        }

        if (!$entity->test(\sndsgd\Fs::EXISTS | \sndsgd\Fs::READABLE)) {
            throw new \sndsgd\form\RuleException($this->getErrorMessage());
        }

        return $value;
    }
}
