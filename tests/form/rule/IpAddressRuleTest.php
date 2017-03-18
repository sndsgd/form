<?php

namespace sndsgd\form\rule;

class IpAddressRuleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerGetDescription
     */
    public function testGetDescription($requirePort, $expect)
    {
        $rule = new IpAddressRule($requirePort);
        $this->assertEquals($expect, $rule->getDescription());
    }

    public function providerGetDescription()
    {
        return [
            [false, "ip"],
            [true, "ip:port"],
        ];
    }

    /**
     * @dataProvider providerGetErrorMessage
     */
    public function testGetErrorMessage($requirePort, $expect)
    {
        $rule = new IpAddressRule($requirePort);
        $this->assertEquals($expect, $rule->getErrorMessage());
    }

    public function providerGetErrorMessage()
    {
        return [
            [false, "must be a valid ip address"],
            [true, "must be a valid ip address and port combination"],
        ];
    }

    /**
     * @dataProvider providerValidate
     */
    public function testValidate($requirePort, $test, $expect)
    {
        $rule = new IpAddressRule($requirePort);
        $this->assertSame($expect, $rule->validate($test));
    }

    public function providerValidate()
    {
        return [
            [false, "123.123.123.123", true],
            [false, "123.123.123.123:123", true],
            [true, "123.123.123.123", false],
            [true, "123.123.123.123:0", false],
            [true, "123.123.123.123:65536", false],
            [true, "123.123.123.123:1", true],
            [true, "123.123.123.123:65535", true],
        ];
    }
}
