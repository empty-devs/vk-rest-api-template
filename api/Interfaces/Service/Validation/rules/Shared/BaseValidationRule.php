<?php

namespace Api\Interfaces\Service\Validation\rules\Shared;

use Api\Constants\Validation\ValidationRuleConstant;
use Api\Interfaces\Service\Validation\ValidationRuleInterface;

abstract class BaseValidationRule implements ValidationRuleInterface
{
    /**
     * @var array<string, mixed>
     */
    protected array $request_params;
    protected string $field;
    protected bool $required;
    /**
     * @var array<string, mixed>
     */
    private array $params = [];
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

        $this->main();
    }

    abstract protected function main(): void;

    public function isRequired(): void
    {
        if (!$this->required) {
            $this->addError(
                ValidationRuleConstant::TYPE_REQUIRED,
                $this->field.' is required.'
            );
        }
    }

    /**
     * @param mixed $value
     * @return void
     */
    protected function addParam($value): void
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

    protected function addError(string $type, string $description): void
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