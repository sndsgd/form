<?php

namespace sndsgd\form\rule;

class WritablePathRuleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider provideGetDescription
     */
    public function testGetDescription(bool $isDirectory, string $expect)
    {
        $rule = new WritablePathRule($isDirectory);
        $this->assertSame($expect, $rule->getDescription());
    }

    public function provideGetDescription(): array
    {
        return [
            [false, _("writable file path")],
            [true, _("writable directory path")],
        ];
    }

    /**
     * @dataProvider provideGetErrorMessage
     */
    public function testGetErrorMessage(bool $isDirectory, string $expect)
    {
        $rule = new WritablePathRule($isDirectory);
        $this->assertSame($expect, $rule->getErrorMessage());
    }

    public function provideGetErrorMessage(): array
    {
        return [
            [false, _("must be a writable file path")],
            [true,  _("must be a writable directory path")],
        ];
    }

    /**
     * @dataProvider provideValidate
     */
    public function testValidate(bool $isDirectory, $path, bool $expect)
    {
        $rule = new WritablePathRule($isDirectory);
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
