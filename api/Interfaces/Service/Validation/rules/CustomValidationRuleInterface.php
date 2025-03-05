<?php

namespace Api\Interfaces\Service\Validation\rules;

interface CustomValidationRuleInterface
{
    /**
     * @param array<string, mixed> $request_params
     * @param string $field
     */
    public function __construct(array $request_params, string $field);

    /**
     * @return array<string, mixed>
     */
    public function getRequestParams(): array;

    public function getField(): string;

    public function isRequired(): bool;

    /**
     * @param mixed $value
     * @return void
     */
    public function addParam($value): void;

    /**
     * @return array<string, mixed>
     */
    public function getParams(): array;

    public function addError(string $type, string $description): void;

    /**
     * @return array<string, array{type: string, description: string}[]>
     */
    public function getErrors(): array;
}