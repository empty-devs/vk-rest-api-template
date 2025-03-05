<?php

namespace Api\Services\Validation\Request;

use Api\Interfaces\Service\Validation\rules\CustomValidationRuleInterface;
use Api\Interfaces\Service\Validation\rules\ValidationRulesInterface;
use Api\Interfaces\Service\Validation\ValidationRuleInterface;
use Api\Services\Validation\Request\rules\BooleanValidationRule;
use Api\Services\Validation\Request\rules\CustomValidationRule;
use Api\Services\Validation\Request\rules\FileValidationRule;
use Api\Services\Validation\Request\rules\FloatValidationRule;
use Api\Services\Validation\Request\rules\NumberValidationRule;
use Api\Services\Validation\Request\rules\StringValidationRule;

final class ValidationRules implements ValidationRulesInterface
{
    /**
     * @var array<string, mixed>
     */
    private array $request_params;
    /**
     * @var array<string, string>
     */
    private array $fields = [];
    /**
     * @var ValidationRuleInterface[]|CustomValidationRuleInterface[]
     */
    private array $rules = [];

    /**
     * @param array<string, mixed> $request_params
     */
    public function __construct(array $request_params)
    {
        $this->request_params = $request_params;
    }

    public function isString(string $field): StringValidationRule
    {
        $this->fields[$field] = $field;

        $rule = new StringValidationRule($this->request_params, $field);
        $this->rules[] = $rule;

        return $rule;
    }

    public function isNumber(string $field): NumberValidationRule
    {
        $this->fields[$field] = $field;

        $rule = new NumberValidationRule($this->request_params, $field);
        $this->rules[] = $rule;

        return $rule;
    }

    public function isFloat(string $field): FloatValidationRule
    {
        $this->fields[$field] = $field;

        $rule = new FloatValidationRule($this->request_params, $field);
        $this->rules[] = $rule;

        return $rule;
    }

    public function isBoolean(string $field): BooleanValidationRule
    {
        $this->fields[$field] = $field;

        $rule = new BooleanValidationRule($this->request_params, $field);
        $this->rules[] = $rule;

        return $rule;
    }

    public function isFile(string $field): FileValidationRule
    {
        $this->fields[$field] = $field;

        $rule = new FileValidationRule($this->request_params, $field);
        $this->rules[] = $rule;

        return $rule;
    }

    public function isCustom(string $field, callable $custom): void
    {
        $this->fields[$field] = $field;

        $rule = new CustomValidationRule($this->request_params, $field);
        $this->rules[] = $rule;

        $custom($rule);
    }

    /**
     * @return array<string, string>
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * @return ValidationRuleInterface[]|CustomValidationRuleInterface[]
     */
    public function getRules(): array
    {
        return $this->rules;
    }
}