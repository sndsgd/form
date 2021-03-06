<?php

namespace sndsgd\form\rule;

/**
 * Convenience class for testing file paths
 */
class FilePathTestRule extends FilesystemPathTestRule
{
    public function __construct(int $tests = \sndsgd\Fs::EXISTS)
    {
	    parent::__construct(false, $tests);
    }
}
