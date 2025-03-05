<?php

namespace Api\Interfaces\Service\Validation\rules;

use Api\Interfaces\Service\Validation\ValidationRuleInterface;
use Api\Services\Validation\Request\rules\BooleanValidationRule;
use Api\Services\Validation\Request\rules\CustomValidationRule;
use Api\Services\Validation\Request\rules\FileValidationRule;
use Api\Services\Validation\Request\rules\FloatValidationRule;
use Api\Services\Validation\Request\rules\NumberValidationRule;
use Api\Services\Validation\Request\rules\StringValidationRule;

interface ValidationRulesInterface
{
    /**
     * @param array<string, mixed> $request_params
     */
    public function __construct(array $request_params);

    public function isString(string $field): StringValidationRule;

    public function isNumber(string $field): NumberValidationRule;

    public function isFloat(string $field): FloatValidationRule;

    public function isBoolean(string $field): BooleanValidationRule;

    public function isFile(string $field): FileValidationRule;

    /**
     * @param callable(CustomValidationRuleInterface $rule): void $custom
     */
    public function isCustom(string $field, callable $custom): void;

    /**
     * @return array<string, string>
     */
    public function getFields(): array;

    /**
     * @return ValidationRuleInterface[]|CustomValidationRuleInterface[]
     */
    public function getRules(): array;
}