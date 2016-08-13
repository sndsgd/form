<?php

namespace sndsgd\form\rule;

/**
 * Ensure a path has a whitelisted extension
 */
class FileExtensionRule extends \sndsgd\form\rule\RuleAbstract
{
    /**
     * The whitelisted extensions
     *
     * @var array<string>
     */
    protected $extensions;

    /**
     * @param array<string> $extensions
     */
    public function __construct(array $extensions)
    {
        if (count($extensions) === 0) {
            throw new \InvalidArgumentException(
                "expecting one or more file extensions"
            );
        }

        $this->extensions = array_map("strtolower", $extensions);
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription(): string
    {
        if (count($this->extensions) === 1) {
            return sprintf(_("file extension:%s"), $this->extensions[0]);
        }

        $extensions = implode(",", $this->extensions);
        return sprintf(_("file extensions:[%s]"), $extensions);
    }

    /**
     * {@inheritdoc}
     */
    public function getErrorMessage(): string
    {
        if (count($this->extensions) === 1) {
            $template = _("must be a file with a %s extension");
            $value = $this->extensions[0];
        } else {
            $template = _("must be a file with one of the following extensions: %s");
            $value = \sndsgd\Arr::implode(", ", $this->extensions, _("or")." ");
        }

        return sprintf($template, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function validate(
        &$value,
        \sndsgd\form\Validator $validator = null
    ): bool
    {
        $file = \sndsgd\Fs::file($value);
        $extension = strtolower($file->getExtension());
        if (!in_array($extension, $this->extensions)) {
            return false;
        }
        return true;
    }
}
