<?php

namespace Api\Managers;

use Api\Constants\Method\MethodConstant;
use Api\Interfaces\Method\ApiMethodInterface;
use Api\Interfaces\Method\ApiValidationInterface;
use Api\Interfaces\Service\Validation\rules\ValidationRulesInterface;
use Api\Services\Http\Response\MethodResponse;
use InvalidArgumentException;

final class MethodManager
{
    private string $namespace_class;
    /**
     * @var class-string<ApiMethodInterface>
     */
    private string $class_method;
    /**
     * @var class-string<ApiValidationInterface>
     */
    private string $class_validation;

    public function __construct(int $version, string $group, string $method, string $action)
    {
        $this->namespace_class = MethodConstant::NAMESPACE.'\\'.$group.'\\'.$method.'\\'.$action.'\\v'.$version;

        $this->setClassMethod();
        $this->setClassValidation();
    }

    private function setClassMethod(): void
    {
        $class_method = $this->namespace_class.'\\Method';

        if (!class_exists($class_method) || !is_subclass_of($class_method, ApiMethodInterface::class)) {
            throw new InvalidArgumentException('Class '.$class_method.' does not exist or does not implement ApiMethodInterface.');
        }

        $this->class_method = $class_method;
    }

    private function setClassValidation(): void
    {
        $class_validation = $this->namespace_class.'\\Validation';

        if (!class_exists($class_validation) || !is_subclass_of($class_validation, ApiValidationInterface::class)) {
            throw new InvalidArgumentException('Class '.$class_validation.' does not exist or does not implement ApiValidationInterface.');
        }

        $this->class_validation = $class_validation;
    }

    /**
     * @param array<string, mixed> $params
     * @param MethodResponse $response
     * @return ApiMethodInterface
     */
    public function getMethod(array $params, MethodResponse $response): ApiMethodInterface
    {
        return new $this->class_method($params, $response);
    }

    public function getValidation(ValidationRulesInterface $rules): ApiValidationInterface
    {
        return new $this->class_validation($rules);
    }
}