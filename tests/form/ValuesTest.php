<?php

namespace sndsgd\form;

class ValuesTest extends \PHPUnit_Framework_TestCase
{
    const VALUES = [
        "type" => "user",
        "attributes" => [
            "id" => [
                "type" => "integer",
                "isPrimaryKey" => true,
            ],
            "email" => [
                "type" => "varchar",
                "length" => 255,
                "isUnique" => true,
            ],
        ],
        "cache" => [
            [
                "driver" => "redis",
                "type" => "model",
                "pool" => "default",
                "attribute" => "id",
                "ttl" => 123,
            ],
            [
                "driver" => "memory",
                "type" => "model",
                "attribute" => "id",
            ],
        ],
    ];

    /**
     * @dataProvider provideGet
     */
    public function testGet(string $name, $expect)
    {
        $values = new Values(self::VALUES);
        $this->assertSame($expect, $values->get($name));
    }

    public function provideGet(): array
    {
        return [
            ["type", "user"],
            ["no", null],
            ["attributes.id.type", "integer"],
            ["attributes.id.nope", null],
            ["cache.0.ttl", 123],
            ["cache.2.driver", null],
        ];
    }

    /**
     * @dataProvider provideGetRelative
     */
    public function testGetRelative(string $start, string $end, $expect)
    {
        $values = new Values(self::VALUES);
        $this->assertSame($expect, $values->getRelative($start, $end));
    }

    public function provideGetRelative(): array
    {
        return [
            ["type", ".cache.0.driver", "redis"],
            ["cache.0.attribute", "...attributes.id.type", "integer"],
            ["cache.0", ".1.driver", "memory"],
        ];
    }
}
