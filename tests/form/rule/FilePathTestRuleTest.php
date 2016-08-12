<?php

namespace sndsgd\form\rule;

class FilePathTestRuleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerGetDescription
     */
    public function testGetDescription($tests, $expect)
    {
        $rule = new FilePathTestRule($tests);
        $this->assertSame($expect, $rule->getDescription());
    }

    public function providerGetDescription()
    {
        $e = \sndsgd\Fs::EXISTS;
        $r = \sndsgd\Fs::READABLE;
        $w = \sndsgd\Fs::WRITABLE;
        $x = \sndsgd\Fs::EXECUTABLE;

        return [
            [0, "file path:---"],
            [$e, "file path:---"],
            [$r, "file path:r--"],
            [$e | $r, "file path:r--"],
            [$w, "file path:-w-"],
            [$e | $w, "file path:-w-"],
            [$x, "file path:--x"],
            [$e | $x, "file path:--x"],
            [$r | $w | $x, "file path:rwx"],
            [$e | $r | $w | $x, "file path:rwx"],
        ];
    }

    /**
     * @dataProvider providerGetErrorMessage
     */
    public function testGetErrorMessage($tests, $expect)
    {
        $rule = new FilePathTestRule($tests);
        $this->assertSame($expect, $rule->getErrorMessage());
    }

    public function providerGetErrorMessage()
    {
        $e = \sndsgd\Fs::EXISTS;
        $r = \sndsgd\Fs::READABLE;
        $w = \sndsgd\Fs::WRITABLE;
        $x = \sndsgd\Fs::EXECUTABLE;

        return [
            [0, "must be a file"],
            [$e, "must be a file"],
            [$r, "must be a readable file"],
            [$e | $r, "must be a readable file"],
            [$w, "must be a writable file"],
            [$e | $w, "must be a writable file"],
            [$x, "must be a executable file"], // ugh
            [$e | $x, "must be a executable file"], // ugh
            [$r | $w | $x, "must be a readable, writable, and executable file"],
            [$e | $r | $w | $x, "must be a readable, writable, and executable file"],
        ];
    }

    /**
     * @dataProvider providerValidate
     */
    public function testValidate($tests, $path, $expect)
    {
        $rule = new FilePathTestRule($tests);
        $this->assertSame($expect, $rule->validate($path));
    }

    public function providerValidate()
    {
        $e = \sndsgd\Fs::EXISTS;
        $r = \sndsgd\Fs::READABLE;
        $w = \sndsgd\Fs::WRITABLE;

        return [
            [$r, __FILE__, true],
            [$e | $r, __FILE__, true],
            [$e | $r | $w, __FILE__, true],
            [$r, "/does/not/exist", false],
            [$e | $r, "/does/not/exist", false],
            [$e | $r | $w, "/does/not/exist", false],
        ];
    }
}
