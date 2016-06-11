<?php

namespace sndsgd\form\detail;

/**
 * @coversDefaultClass \sndsgd\form\detail\DetailAbstract
 */
class DetailAbstractTest extends \PHPUnit_Framework_TestCase
{
    protected $detail;

    public function setup()
    {
        $field = new \sndsgd\form\field\ValueField("test");
        $this->detail = $this->getMockBuilder(DetailAbstract::class)
            ->setConstructorArgs([$field])
            ->setMethods(["getKeyRules"])
            ->getMockForAbstractClass();

        $this->detail->method("getKeyRules")->willReturn([]);
    }

    /**
     * @dataProvider providerGetRulesFromField
     */
    public function testGetRulesFromField($field, $expect)
    {
        $detail = $field->getDetail();
        $rc = new \ReflectionClass($detail);
        $method = $rc->getMethod("getRulesFromField");
        $method->setAccessible(true);

        $this->assertSame($method->invoke($detail, $field), $expect);
    }

    public function providerGetRulesFromField()
    {
        $field = new \sndsgd\form\field\ValueField();
        $integerRule = new \sndsgd\form\rule\IntegerRule();
        $minRule = new \sndsgd\form\rule\MinRule(10);

        return [
            [
                (clone $field)->addRules($integerRule),
                [
                    [
                        "description" => $integerRule->getDescription(),
                        "errorMessage" => $integerRule->getErrorMessage(),
                    ],
                ]
            ],
            [
                (clone $field)->addRules($integerRule, $minRule),
                [
                    [
                        "description" => $integerRule->getDescription(),
                        "errorMessage" => $integerRule->getErrorMessage(),
                    ],
                    [
                        "description" => $minRule->getDescription(),
                        "errorMessage" => $minRule->getErrorMessage(),
                    ],
                ]
            ],
        ];
    }

    public function testToArray()
    {
        $result = $this->detail->toArray();
        $this->assertArrayHasKey("name", $result);
        $this->assertArrayHasKey("type", $result);
        $this->assertArrayHasKey("signature", $result);
        $this->assertArrayHasKey("description", $result);
        $this->assertArrayHasKey("default", $result);
        $this->assertArrayHasKey("rules", $result);
    }

    /**
     * @covers ::jsonSerialize
     */
    public function testJsonSerialize()
    {
        $this->assertTrue(is_string(json_encode($this->detail)));
    }
}
