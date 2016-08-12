<?php

namespace sndsgd\form\rule;

class FilesystemParentRuleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerConstructor
     */
    public function testConstructor($test, $exception)
    {
        if ($exception) {
            $this->setExpectedException($exception);
        }
        $rule = new FilesystemParentRule($test);
    }

    public function providerConstructor()
    {
        return [
            [[], \InvalidArgumentException::class],
            [["/some/path"], ""],
        ];
    }

    /**
     * @dataProvider providerGetDescription
     */
    public function testGetDescription($test, $expect)
    {
        $rule = new FilesystemParentRule($test);
        $this->assertSame($expect, $rule->getDescription());
    }

    public function providerGetDescription()
    {
        return [
            [["/a/b"], "parent path:/a/b"],
            [["/a/b", "/c/d"], "parent paths:[/a/b,/c/d]"],
        ];
    }

    /**
     * @dataProvider providerGetErrorMessage
     */
    public function testGetErrorMessage($tests, $expect)
    {
        $rule = new FilesystemParentRule($tests);
        $this->assertSame($expect, $rule->getErrorMessage());
    }

    public function providerGetErrorMessage()
    {
        return [
            [
                ["/a/b"], 
                "value must be a child of /a/b",
            ],
            [
                ["/a/b", "/c/d"],
                "value must be a child of /a/b, or /c/d",
            ],
        ];
    }

    /**
     * @dataProvider providerValidate
     */
    public function testValidate($parentPaths, $path, $expect)
    {
        $rule = new FilesystemParentRule($parentPaths);
        $this->assertSame($expect, $rule->validate($path));
    }

    public function providerValidate()
    {
        return [
            [["/a/b"], "/c/d", false],
            [["/a/b", "/c/d"], "/c/d/e", true],
            [["/a/b"], "/a/c/../b/e", true],
        ];
    }
}
