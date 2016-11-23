<?php

namespace sndsgd\form\rule;

use \sndsgd\form\field\FieldInterface;
use \sndsgd\Func;

class ClosureRule extends RuleAbstract
{
    /**
     * The validation handler
     *
     * @var callable
     */
    protected $handler;

    /**
     * @var string
     */
    protected $classname;

    /**
     * A summary of what the field stores
     *
     * @var string
     */
    protected $description;

    /**
     * @param callable $handler The function/static method to use for validation
     * @throws \InvalidArgumentException
     */
    public function __construct(callable $handler)
    {
        if (!$this->verifyHandler($handler)) {
            throw new \InvalidArgumentException(
                "invalid value provided for 'handler'; ".
                "expecting either a valid function / static method name as ".
                "string or a closure with the following signature: ".
                "`function(&\$value, \sndsgd\form\Validator \$validator = null): bool`"
            );
        }

        $this->handler = $handler;
    }

    /**
     * Verify the validate function has the correct signature
     *
     * @param callable $func
     * @return bool
     */
    private function verifyHandler(callable $func): bool
    {
        $reflection = Func::getReflection($func);
        $params = $reflection->getParameters();
        if (count($params) !== 2) {
            return false;
        }

        list($value, $validator) = $params;

        # `$value` must
        # - have no typehint
        # - not be optional
        # - be passed by reference
        if (
            $value->getType() !== null ||
            $value->isOptional()
            //!$value->isPassedByReference()
        ) {
            return false;
        }

        # validator must
        # - have a typehint of \sndsgd\form\Validator
        # - be optional
        # - have a default value of `null`
        $type = $validator->getType();
        if (
            !$type ||
            (string) $type !== \sndsgd\form\Validator::class ||
            !$type->allowsNull()
        ) {
            return false;
        }

        # return type must be boolean
        $returnType = $reflection->getReturnType();
        if (!$returnType || (string) $returnType !== "bool") {
            return false;
        }

        $this->classname = __CLASS__."\\".md5($reflection);
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getClass(): string
    {
        if (is_string($this->handler)) {
            return $this->handler;
        }
        return $this->classname;
    }

    /**
     * @param string $description
     * @return \sndsgd\form\rule\ClosureRule
     */
    public function setDescription(string $description): ClosureRule
    {
        $this->description = $description;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * {@inheritdoc}
     */
    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }

    /**
     * {@inheritdoc}
     */
    public function validate(
        &$value,
        \sndsgd\form\Validator $validator = null
    ): bool
    {
        return call_user_func($this->handler, $value, $validator);
    }
}
