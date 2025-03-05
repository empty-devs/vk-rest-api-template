<?php

namespace Api\Services\Validation\Request\rules;

use Api\Constants\Validation\ValidationRuleConstant;
use Api\Interfaces\Service\Validation\rules\Shared\BaseValidationRule;
use TypeError;

final class StringValidationRule extends BaseValidationRule
{
    protected function main(): void
    {
        if ($this->required && (!is_string($this->request_params[$this->field]) ||
                trim($this->request_params[$this->field]) === '')) {
            $this->addError(
                ValidationRuleConstant::TYPE_STRING,
                $this->field.' must be a string.'
            );
        }
    }

    public function setRegex(string $regex): self
    {
        if ($this->required && preg_match($regex, $this->request_params[$this->field]) !== 1) {
            $this->addError(
                ValidationRuleConstant::TYPE_REGEX,
                $this->field.' format is invalid.'
            );
        }

        return $this;
    }

    /**
     * @param array<string> $in
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
        if ($this->required) {
            try {
                $len = mb_strlen(trim($this->request_params[$this->field]));
            } catch (TypeError $e) {
                $len = -1;
            }

            if ($len < $min) {
                $this->addError(
                    ValidationRuleConstant::TYPE_MIN,
                    $this->field.' must be at least '.$min.' characters.'
                );
            }
        }

        return $this;
    }

    public function setMax(int $max): self
    {
        if ($this->required) {
            try {
                $len = mb_strlen(trim($this->request_params[$this->field]));
            } catch (TypeError $e) {
                $len = -1;
            }

            if ($len > $max) {
                $this->addError(
                    ValidationRuleConstant::TYPE_MAX,
                    $this->field.' may not be greater than '.$max.' characters.'
                );
            }
        }

        return $this;
    }

    public function defaultValue(string $value): void
    {
        if (!$this->required) {
            $this->addParam($value);
        }
    }
}