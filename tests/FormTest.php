<?php

namespace sndsgd;

class FormTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        new Form();
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructorException()
    {
        new Form("names-are-not-allowed");
    }

    /**
     * @dataProvider provideMerge
     */
    public function testMerge($form, array $forms, $expectFields)
    {
        $form->merge(...$forms);
        $allFields = $form->getFields();

        foreach ($expectFields as $field) {
            $this->assertArrayHasKey($field, $allFields);
        }
    }

    public function provideMerge(): array
    {
        return [
            [
                $this->createForm("one"),
                [
                    $this->createForm("two"),
                    $this->createForm("three"),
                ],
                ["one", "two", "three"],
            ],
            [
                $this->createForm("one", "two"),
                [
                    $this->createForm("three"),
                    $this->createForm("four"),
                ],
                ["one", "two", "three", "four"],
            ],
            [
                $this->createForm(),
                [
                    $this->createForm("one"),
                    $this->createForm("two"),
                    $this->createForm("three"),
                ],
                ["one", "two", "three"],
            ],
            [
                $this->createForm(),
                [
                    $this->createForm("one", "two"),
                    $this->createForm("three"),
                    $this->createForm("four", "five"),
                ],
                ["one", "two", "three", "four", "five"],
            ],
        ];
    }

    private function createForm(string ...$fields): Form
    {
        $ret = new Form();
        foreach ($fields as $name) {
            $ret->addFields(new \sndsgd\form\field\StringField($name));
        }
        return $ret;
    }
}
