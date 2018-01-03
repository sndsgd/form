<?php

namespace sndsgd\form\field;

class ValueField extends FieldAbstract
{
    /**
     * The human readable type of the field
     *
     * @var string
     */
    protected $type = "";

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @inheritDoc
     */
    public function validate($values, \sndsgd\form\Validator $validator)
    {
        # @todo can the "use first element of an array" logic be nuked?
        if (is_array($values)) {
            $len = count($values);
            if ($len > 1) {
                $noun = \sndsgd\Arr::isIndexed($values) ? "array" : "object";
                $message = "expecting a scalar value; $noun encountered";
                $validator->addError($message);
                return null;
            }
            $values = $values[0];
        }

        if (
            is_null($values) &&
            !$this->hasRule(\sndsgd\form\rule\RequiredRule::class)
        ) {
            return $this->defaultValue;
        }

        try {
            foreach ($this->rules as $rule) {
                $values = $rule->validate($values, $validator);
            }
        } catch (\sndsgd\form\RuleException $ex) {
            $validator->addError($ex->getClientMessage());
            return null;
        }

        return $values;
    }

    /**
     * @inheritDoc
     */
    public function getDetail(): \sndsgd\form\detail\DetailInterface
    {
        return new \sndsgd\form\detail\ValueFieldDetail($this);
    }
}
