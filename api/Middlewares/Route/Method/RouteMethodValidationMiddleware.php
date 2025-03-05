<?php

namespace Api\Middlewares\Route\Method;

use Api\Constants\Exception\ApiExceptionConstant;
use Api\Constants\Http\RequestConstant;
use Api\Exceptions\ApiException;
use Api\Interfaces\Middleware\MiddlewareInterface;

final class RouteMethodValidationMiddleware implements MiddlewareInterface
{
    /**
     * @var array{version: int, group: string, method: string, action: string, uid: string}
     */
    private array $path_params;
    /**
     * @var array<string, array<string, array{actions: array<string, mixed>, active: bool}>>
     */
    private array $routes;

    /**
     * @param array{version: int, group: string, method: string, action: string, uid: string} $path_params
     * @param array<string, array<string, array{actions: array<string, mixed>, active: bool}>> $routes
     */
    public function __construct(array $path_params, array $routes)
    {
        $this->path_params = $path_params;
        $this->routes = $routes;
    }

    public function check(): void
    {
        if (!isset($this->routes[$this->path_params['group']][$this->path_params['method']]['actions'][$this->path_params['action']])) {
            throw new ApiException(
                ApiExceptionConstant::TYPE_METHOD_NOT_FOUND,
                'Method does not exist.',
                RequestConstant::CODE_NOT_FOUND
            );
        }
    }
}