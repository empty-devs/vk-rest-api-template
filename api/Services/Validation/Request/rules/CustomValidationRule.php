<?php

namespace Api\Services\Validation\Request\rules;

use Api\Interfaces\Service\Validation\rules\CustomValidationRuleInterface;

final class CustomValidationRule implements CustomValidationRuleInterface
{
    /**
     * @var array<string, mixed>
     */
    private array $request_params;
    private string $field;
    private bool $required;
    /**
     * @var array<string, mixed>
     */
    protected array $params = [];
    /**
     * @var array<string, array{type: string, description: string}[]>
     */
    private array $errors = [];

    /**
     * @param array<string, mixed> $request_params
     * @param string $field
     */
    public function __construct(array $request_params, string $field)
    {
        $this->request_params = $request_params;
        $this->field = $field;
        $this->required = isset($this->request_params[$this->field]);
    }

    /**
     * @return array<string, mixed>
     */
    public function getRequestParams(): array
    {
        return $this->request_params;
    }

    public function getField(): string
    {
        return $this->field;
    }

    public function isRequired(): bool
    {
        return $this->required;
    }

    /**
     * @param mixed $value
     * @return void
     */
    public function addParam($value): void
    {
        $this->params[$this->field] = $value;
    }

    /**
     * @return array<string, mixed>
     */
    public function getParams(): array
    {
        return $this->params;
    }

    public function addError(string $type, string $description): void
    {
        $this->errors[$this->field][] = [
            'type' => $type,
            'description' => $description
        ];
    }

    /**
     * @return array<string, array{type: string, description: string}[]>
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}