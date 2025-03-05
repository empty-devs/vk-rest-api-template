<?php

namespace Api\Services\Validation\Request\rules;

use Api\Constants\Validation\ValidationRuleConstant;
use Api\Interfaces\Service\Validation\rules\Shared\BaseValidationRule;

final class BooleanValidationRule extends BaseValidationRule
{
    protected function main(): void
    {
        if ($this->required && !is_bool($this->request_params[$this->field])) {
            $this->addError(
                ValidationRuleConstant::TYPE_BOOLEAN,
                $this->field.' must be a boolean.'
            );
        }
    }

    /**
     * @param array<bool> $in
     * @return void
     */
    public function setIn(array $in): void
    {
        if ($this->required && !in_array($this->request_params[$this->field], $in, true)) {
            $this->addError(
                ValidationRuleConstant::TYPE_IN,
                $this->field.' must be one of: '.implode(', ', $in)
            );
        }
    }

    public function defaultValue(bool $value): void
    {
        if (!$this->required) {
            $this->addParam($value);
        }
    }
}