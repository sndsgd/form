<?php

namespace sndsgd\form\rule;

class FileExtensionRuleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerConstructor
     */
    public function testConstructor($test, $exception)
    {
        if ($exception) {
            $this->setExpectedException($exception);
        }
        $rule = new FileExtensionRule($test);
    }

    public function providerConstructor()
    {
        return [
            [[], \InvalidArgumentException::class],
            [["jpg"], ""],
        ];
    }

    /**
     * @dataProvider providerGetDescription
     */
    public function testGetDescription($test, $expect)
    {
        $rule = new FileExtensionRule($test);
        $this->assertSame($expect, $rule->getDescription());
    }

    public function providerGetDescription()
    {
        return [
            [["jpg"], "file extension:jpg"],
            [["jpg", "png"], "file extensions:[jpg,png]"],
        ];
    }

    /**
     * @dataProvider providerGetErrorMessage
     */
    public function testGetErrorMessage($tests, $expect)
    {
        $rule = new FileExtensionRule($tests);
        $this->assertSame($expect, $rule->getErrorMessage());
    }

    public function providerGetErrorMessage()
    {
        return [
            [
                ["jpg"], 
                "must be a file with a jpg extension",
            ],
            [
                ["jpg", "png"],
                "must be a file with one of the following extensions: jpg, or png",
            ],
        ];
    }

    /**
     * @dataProvider providerValidate
     */
    public function testValidate($extensions, $path, $expect)
    {
        $rule = new FileExtensionRule($extensions);
        $this->assertSame($expect, $rule->validate($path));
    }

    public function providerValidate()
    {
        return [
            [["jpg"], "/some/file", false],
            [["jpg"], "/some/.jpg", false],
            [["jpg"], "/some/file.txt", false],
            [["jpg", "png"], "/some/file.txt", false],
            [["jpg", "png", "txt"], "/some/file.txt", true],
            [["QwErTy", "ThINg"], "/some/file.nope", false],
            [["QwErTy", "ThINg"], "/some/file.thing", true],
        ];
    }
}
