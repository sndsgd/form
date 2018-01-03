<?php

namespace sndsgd\form\rule;

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
        if (!$this->isValidHandler($handler)) {
            throw new \InvalidArgumentException(
                "invalid value provided for 'handler'; ".
                "expecting either a valid function / static method name as ".
                "string or a closure with the following signature: ".
                "`function(\$value, \\sndsgd\\form\\Validator \$validator = null)`"
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
    private function isValidHandler(callable $func): bool
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
        if ($value->getType() !== null || $value->isOptional()) {
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

        # must not have a return type
        if ($reflection->getReturnType()) {
            return false;
        }

        $this->classname = __CLASS__."\\".md5($reflection);
        return true;
    }

    /**
     * @inheritDoc
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
     * @inheritDoc
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @inheritDoc
     */
    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }

    /**
     * @inheritDoc
     */
    public function validate($value, \sndsgd\form\Validator $validator = null)
    {
        # using `call_user_func()` here doesn't pass `$value` by reference
        # PHP Warning: Parameter 1 expected to be a reference, value given
        $func = $this->handler;
        return $func($value, $validator);
    }
}
