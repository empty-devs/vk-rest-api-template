<?php

namespace Api\Interfaces\Method\Shared;

use Api\Interfaces\Method\ApiValidationInterface;
use Api\Interfaces\Service\Validation\rules\ValidationRulesInterface;

abstract class BaseValidation implements ApiValidationInterface
{
    protected ValidationRulesInterface $rules;

    public function __construct(ValidationRulesInterface $rules)
    {
        $this->rules = $rules;
    }

    abstract public function main(): void;
}
