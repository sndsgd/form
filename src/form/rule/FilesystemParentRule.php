<?php

namespace sndsgd\form\rule;

/**
 * Ensure a path is a child of one or more directories
 */
class FilesystemParentRule extends \sndsgd\form\rule\RuleAbstract
{
    /**
     * The whitelisted parent paths
     *
     * @var array<string>
     */
    protected $parentPaths;

    /**
     * @param array<string> $parentPaths
     */
    public function __construct(array $parentPaths)
    {
        if (empty($parentPaths)) {
            throw new \InvalidArgumentException(
                "expecting one or more parent paths"
            );
        }
        $this->parentPaths = $parentPaths;
    }

    /**
     * @inheritDoc
     */
    public function getDescription(): string
    {
        if (count($this->parentPaths) === 1) {
            return sprintf(_("parent path:%s"), $this->parentPaths[0]);
        }

        $paths = implode(",", $this->parentPaths);
        return sprintf(_("parent paths:[%s]"), $paths);
    }

    /**
     * @inheritDoc
     */
    public function getErrorMessage(): string
    {
        $template = _("value must be a child of %s");
        if (count($this->parentPaths) === 1) {
            return sprintf($template, $this->parentPaths[0]);
        }

        $parents = \sndsgd\Arr::implode(", ", $this->parentPaths, _("or")." ");
        return sprintf($template, $parents);
    }

    /**
     * @inheritDoc
     */
    public function validate(
        &$value,
        \sndsgd\form\Validator $validator = null
    ): bool
    {
        if ($value instanceof \sndsgd\fs\entity\EntityInterface) {
            $file = $value;
        } else {
            $file = \sndsgd\fs::file($value);
        }

        foreach ($this->parentPaths as $parent) {
            if (strpos($file, $parent) === 0) {
                return true;
            }
        }
        return false;
    }
}
