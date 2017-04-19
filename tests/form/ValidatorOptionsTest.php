<?php

namespace sndsgd\form;

/**
 * @coversDefaultClass \sndsgd\form\ValidatorOptions
 */
class ValidatorOptionsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers ::setNameDelimiter
     * @covers ::getNameDelimiter
     */
    public function testSetGetNameDelimiter()
    {
        $delimiter = "blegh";
        $options = new ValidatorOptions();
        $result = $options->setNameDelimiter($delimiter);
        $this->assertSame($delimiter, $options->getNameDelimiter());
    }

    /**
     * @covers ::setFieldType
     * @covers ::getFieldType
     */
    public function testSetGetFieldType()
    {
        $type = "blegh";
        $options = new ValidatorOptions();
        $result = $options->setFieldType($type);
        $this->assertSame($type, $options->getFieldType());
    }

    /**
     * @covers ::setAllowUnknownFields
     * @covers ::getAllowUnknownFields
     */
    public function testSetGetAllowUnknownFields()
    {
        $options = new ValidatorOptions();
        $this->assertFalse($options->getAllowUnknownFields());

        $options->setAllowUnknownFields(true);
        $this->assertTrue($options->getAllowUnknownFields());
    }
}
