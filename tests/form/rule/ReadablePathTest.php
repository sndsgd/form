<?php

namespace sndsgd\form\rule;

class ReadablePathRuleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider provideGetDescription
     */
    public function testGetDescription(bool $isDirectory, string $expect)
    {
        $rule = new ReadablePathRule($isDirectory);
        $this->assertSame($expect, $rule->getDescription());
    }

    public function provideGetDescription(): array
    {
        return [
            [false, _("readable file path")],
            [true, _("readable directory path")],
        ];
    }

    /**
     * @dataProvider provideGetErrorMessage
     */
    public function testGetErrorMessage(bool $isDirectory, string $expect)
    {
        $rule = new ReadablePathRule($isDirectory);
        $this->assertSame($expect, $rule->getErrorMessage());
    }

    public function provideGetErrorMessage(): array
    {
        return [
            [false, _("must be a readable file path")],
            [true,  _("must be a readable directory path")],
        ];
    }

    /**
     * @dataProvider provideValidate
     */
    public function testValidate(bool $isDirectory, $path, bool $expect)
    {
        $rule = new ReadablePathRule($isDirectory);
        $this->assertSame($expect, $rule->validate($path));
    }

    public function provideValidate(): array
    {
        return [
            [false, __FILE__, true],
            [false, \sndsgd\Fs::file(__FILE__), true],
            [true, __DIR__, true],
            [true, \sndsgd\Fs::dir(__DIR__), true],
        ];
    }
}
