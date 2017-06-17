<?php

namespace sndsgd\form\rule;

/**
 * Convenience class for testing file paths
 */
class DirectoryPathTestRule extends FilesystemPathTestRule
{
    public function __construct(int $tests = \sndsgd\Fs::EXISTS)
    {
	    parent::__construct(true, $tests);
    }
}
