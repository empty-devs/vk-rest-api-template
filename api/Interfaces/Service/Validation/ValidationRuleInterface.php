<?php

namespace Api\Interfaces\Service\Validation;

interface ValidationRuleInterface
{
    /**
     * @param array<string, mixed> $request_params
     * @param string $field
     */
    public function __construct(array $request_params, string $field);

    public function isRequired(): void;

    /**
     * @return array<string, mixed>
     */
    public function getParams(): array;

    /**
     * @return array<string, array{type: string, description: string}[]>
     */
    public function getErrors(): array;
}