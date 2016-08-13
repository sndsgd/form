<?php

namespace sndsgd\form\rule;

/**
 * Ensure a value is a file path with appropriate permissions
 */
class FilePathTestRule extends RuleAbstract
{
    /**
     * A bitmask of tests to perform on the path
     *
     * @var int
     */
    protected $tests;

    /**
     * @param int $tests
     */
    public function __construct(int $tests = \sndsgd\Fs::EXISTS)
    {
        $this->tests = $tests | \sndsgd\Fs::EXISTS;
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription(): string
    {
        $chars = "";
        $testTypes = $this->getTestTypes();
        foreach (["r", "w", "x"] as $char) {
            $chars .= isset($testTypes[$char]) ? $char : "-";
        }

        return sprintf(_("file path:%s"), $chars);
    }

    /**
     * {@inheritdoc}
     */
    public function getErrorMessage(): string
    {
        if ($this->errorMessage) {
            return $this->errorMessage;
        }

        $testTypes = array_values($this->getTestTypes());
        switch (count($testTypes)) {
            case 0:
                return _("must be a file");
            case 1: 
                $desc = $testTypes[0];
                break;
            case 2:
                $desc = $testTypes[0]." "._("and")." ".$testTypes[1];
                break;
            default:
                $desc = \sndsgd\Arr::implode(", ", $testTypes, _("and")." ");
        }

        return sprintf(_("must be a %s file"), $desc);
    }

    /**
     * Retrieve the test permissions as a list of descriptions
     *
     * @return array<string,string>
     */
    public function getTestTypes(): array
    {
        $ret = [];
        if ($this->tests & \sndsgd\Fs::READABLE) {
            $ret["r"] = _("readable");
        }
        if ($this->tests & \sndsgd\Fs::WRITABLE) {
            $ret["w"] = _("writable");
        }
        if ($this->tests & \sndsgd\Fs::EXECUTABLE) {
            $ret["x"] = _("executable");
        }
        return $ret;
    }

    /**
     * {@inheritdoc}
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

        if (!$file->test($this->tests)) {
            return false;
        }

        $value = $file;
        return true;
    }
}
