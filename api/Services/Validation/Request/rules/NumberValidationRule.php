<?php

namespace Api\Services\Validation\Request\rules;

use Api\Constants\Validation\ValidationRuleConstant;
use Api\Interfaces\Service\Validation\rules\Shared\BaseValidationRule;

final class NumberValidationRule extends BaseValidationRule
{
    protected function main(): void
    {
        if ($this->required && !is_numeric($this->request_params[$this->field])) {
            $this->addError(
                ValidationRuleConstant::TYPE_NUMBER,
                $this->field.' must be an number.'
            );
        }
    }

    public function isInteger(): self
    {
        if ($this->required && !is_int($this->request_params[$this->field])) {
            $this->addError(
                ValidationRuleConstant::TYPE_INTEGER,
                $this->field.' must be an integer.'
            );
        }

        return $this;
    }

    /**
     * @param array<int|string> $in
     * @return $this
     */
    public function setIn(array $in): self
    {
        if ($this->required && !in_array($this->request_params[$this->field], $in, true)) {
            $this->addError(
                ValidationRuleConstant::TYPE_IN,
                $this->field.' must be one of: '.implode(', ', $in)
            );
        }

        return $this;
    }

    public function setMin(int $min): self
    {
        if ($this->required && $this->request_params[$this->field] < $min) {
            $this->addError(
                ValidationRuleConstant::TYPE_MIN,
                $this->field.' must be at least '.$min.'.'
            );
        }

        return $this;
    }

    public function setMax(int $max): self
    {
        if ($this->required && $this->request_params[$this->field] > $max) {
            $this->addError(
                ValidationRuleConstant::TYPE_MAX,
                $this->field.' may not be greater than '.$max.'.'
            );
        }

        return $this;
    }

    public function defaultValue(int $value): void
    {
        if (!$this->required) {
            $this->addParam($value);
        }
    }
}