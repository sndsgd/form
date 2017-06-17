<?php

namespace sndsgd\form\rule;

/**
 * Ensure a value is a filesystem entity with appropriate permissions
 */
class FilesystemPathTestRule extends RuleAbstract
{
    /**
     * Whether to test paths as directories or files
     *
     * @var bool
     */
    protected $isDir;

    /**
     * A bitmask of tests to perform on the path
     *
     * @var int
     */
    protected $tests;


    public function __construct(bool $isDir = false, int $tests = \sndsgd\Fs::EXISTS)
    {
	$this->isDir = $isDir;
	$this->tests = $tests | \sndsgd\Fs::EXISTS;
    }

    /**
     * @inheritDoc
     */
    public function getDescription(): string
    {
	$chars = "";
	$testTypes = $this->getTestTypes();
	foreach (["r", "w", "x"] as $char) {
	    $chars .= isset($testTypes[$char]) ? $char : "-";
	}

	if ($this->isDir) {
	    return sprintf(_("directory path:%s"), $chars);
	}

	return sprintf(_("file path:%s"), $chars);
    }

    /**
     * @inheritDoc
     */
    public function getErrorMessage(): string
    {
	if ($this->errorMessage) {
	    return $this->errorMessage;
	}

	$testTypes = array_values($this->getTestTypes());
	switch (count($testTypes)) {
	    case 0:
		return $this->isDir ? _("must be a directory") : _("must be a file");
	    case 1:
		$desc = $testTypes[0];
		break;
	    case 2:
		$desc = $testTypes[0]." "._("and")." ".$testTypes[1];
		break;
	    default:
		$desc = \sndsgd\Arr::implode(", ", $testTypes, _("and")." ");
	}

	if ($this->isDir) {
	    return sprintf(_("must be a %s directory"), $desc);
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
	if (!$this->isDir && $this->tests & \sndsgd\Fs::EXECUTABLE) {
	    $ret["x"] = _("executable");
	}
	return $ret;
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
	    $entity = $value;
	} elseif ($this->isDir) {
	    $entity = \sndsgd\fs::dir($value);
	} else {
	    $entity = \sndsgd\fs::file($value);
	}

	if (!$entity->test($this->tests)) {
	    return false;
	}

	$value = $entity;
	return true;
    }
}
