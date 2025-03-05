<?php

namespace Api\Middlewares\Http\Request;

use Api\Constants\Exception\ApiExceptionConstant;
use Api\Constants\Http\RequestConstant;
use Api\Exceptions\ApiException;
use Api\Interfaces\Middleware\MiddlewareInterface;

final class RequestMiddleware implements MiddlewareInterface
{
    private bool $is_success;
    /**
     * @var array<string, array{type: string, description: string}[]>
     */
    private array $errors;

    /**
     * @param bool $is_success
     * @param array<string, array{type: string, description: string}[]> $errors
     */
    public function __construct(bool $is_success, array $errors)
    {
        $this->is_success = $is_success;
        $this->errors = $errors;
    }

    public function check(): void
    {
        if (!$this->is_success) {
            throw new ApiException(
                ApiExceptionConstant::TYPE_BAD_REQUEST_DATA,
                'Incorrect request data.',
                RequestConstant::CODE_BAD_REQUEST,
                $this->errors
            );
        }
    }
}