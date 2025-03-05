<?php

namespace Api\Services\Validation\Request;

use Api\Interfaces\Service\Validation\rules\ValidationRulesInterface;

final class RequestValidator
{
    private ValidationRulesInterface $validation_rules;
    /**
     * @var array<string, mixed>
     */
    private array $params;
    /**
     * @var array<string, array{type: string, description: string}[]>
     */
    private array $errors = [];

    public function __construct(ValidationRulesInterface $validation_rules)
    {
        $this->validation_rules = $validation_rules;
    }

    public function getValidationRules(): ValidationRulesInterface
    {
        return $this->validation_rules;
    }

    public function validate(): void
    {
        $params = [];
        $errors = [];

        foreach ($this->validation_rules->getRules() as $rule) {
            $params += $rule->getParams();
            $errors += $rule->getErrors();
        }

        $this->params = $params;
        $this->errors = $errors;
    }

    /**
     * @return array<string, mixed>
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @return array<string, array{type: string, description: string}[]>
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    public function isSuccess(): bool
    {
        return $this->errors === [];
    }
}