<?php

namespace sndsgd\form\rule;

class FilesystemPathTestRuleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerGetDescription
     */
    public function testGetDescription($isDir, $tests, $expect)
    {
        $rule = new FilesystemPathTestRule($isDir, $tests);
        $this->assertSame($expect, $rule->getDescription());
    }

    public function providerGetDescription()
    {
        $e = \sndsgd\Fs::EXISTS;
        $r = \sndsgd\Fs::READABLE;
        $w = \sndsgd\Fs::WRITABLE;
        $x = \sndsgd\Fs::EXECUTABLE;

        return [
            [false, 0, "file path:---"],
            [false, $e, "file path:---"],
            [false, $r, "file path:r--"],
            [false, $e | $r, "file path:r--"],
            [false, $w, "file path:-w-"],
            [false, $e | $w, "file path:-w-"],
            [false, $x, "file path:--x"],
            [false, $e | $x, "file path:--x"],
            [false, $r | $w | $x, "file path:rwx"],
            [false, $e | $r | $w | $x, "file path:rwx"],
            [true, 0, "directory path:---"],
            [true, $e, "directory path:---"],
            [true, $r, "directory path:r--"],
            [true, $w, "directory path:-w-"],
        ];
    }

    public function testGetErrorMessageCustom()
    {
        $rule = new FilesystemPathTestRule();
        $expect = "custom error message";
        $rule->setErrorMessage($expect);
        $this->assertSame($expect, $rule->getErrorMessage());
    }

    /**
     * @dataProvider providerGetErrorMessage
     */
    public function testGetErrorMessage($isDir, $tests, $expect)
    {
        $rule = new FilesystemPathTestRule($isDir, $tests);
        $this->assertSame($expect, $rule->getErrorMessage());
    }

    public function providerGetErrorMessage()
    {
        $e = \sndsgd\Fs::EXISTS;
        $r = \sndsgd\Fs::READABLE;
        $w = \sndsgd\Fs::WRITABLE;
        $x = \sndsgd\Fs::EXECUTABLE;

        return [
            [false, 0, "must be a file"],
            [false, $e, "must be a file"],
            [false, $r, "must be a readable file"],
            [false, $e | $r, "must be a readable file"],
            [false, $w, "must be a writable file"],
            [false, $e | $w, "must be a writable file"],
            [false, $x, "must be a executable file"], // ugh
            [false, $e | $x, "must be a executable file"], // ugh
            [false, $r | $w, "must be a readable and writable file"],
            [false, $r | $w | $x, "must be a readable, writable, and executable file"],
            [false, $e | $r | $w | $x, "must be a readable, writable, and executable file"],

            [true, $r, "must be a readable directory"],

        ];
    }

    /**
     * @dataProvider providerValidate
     */
    public function testValidate($isDir, $tests, $path, $expect)
    {
        $rule = new FilesystemPathTestRule($isDir, $tests);
        $this->assertSame($expect, $rule->validate($path));
    }

    public function providerValidate()
    {
        $e = \sndsgd\Fs::EXISTS;
        $r = \sndsgd\Fs::READABLE;
        $w = \sndsgd\Fs::WRITABLE;

        return [
            # file
            [false, $r, __FILE__, true],
            [false, $e | $r, __FILE__, true],
            [false, $e | $r | $w, __FILE__, true],
            [false, $r, "/does/not/exist", false],
            [false, $e | $r, "/does/not/exist", false],
            [false, $e | $r | $w, "/does/not/exist", false],
            [false, $r, \sndsgd\Fs::file(__FILE__), true],
            [false, $r, \sndsgd\Fs::file("/does/not/exist"), false],

            # directory
            [true, $r, __DIR__, true],
            [true, $e | $r, __DIR__, true],
            [true, $e | $r | $w, __DIR__, true],
            [true, $r, "/does/not/exist", false],
            [true, $e | $r, "/does/not/exist", false],
            [true, $e | $r | $w, "/does/not/exist", false],
            [true, $r, \sndsgd\Fs::dir(__DIR__), true],
            [true, $r, \sndsgd\Fs::file("/does/not/exist"), false],
        ];
    }
}
