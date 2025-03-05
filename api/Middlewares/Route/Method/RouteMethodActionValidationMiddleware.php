<?php

namespace Api\Middlewares\Route\Method;

use Api\Constants\Exception\ApiExceptionConstant;
use Api\Constants\Http\RequestConstant;
use Api\Exceptions\ApiException;
use Api\Interfaces\Middleware\MiddlewareInterface;

final class RouteMethodActionValidationMiddleware implements MiddlewareInterface
{
    private string $http_method;
    /**
     * @var array{version: int, group: string, method: string, action: string, uid: string}
     */
    private array $path_params;
    /**
     * @var array<string, array<string, array{actions: array<string, array{version: int, http_method: string, access: int, wait_file: bool, no_auth: bool, deprecated: bool, active: bool}|array{}>, active: bool}>>
     */
    private array $routes;

    /**
     * @param string $http_method
     * @param array{version: int, group: string, method: string, action: string, uid: string} $path_params
     * @param array<string, array<string, array{actions: array<string, array{version: int, http_method: string, access: int, wait_file: bool, no_auth: bool, deprecated: bool, active: bool}|array{}>, active: bool}>> $routes
     */
    public function __construct(string $http_method, array $path_params, array $routes)
    {
        $this->http_method = $http_method;
        $this->path_params = $path_params;
        $this->routes = $routes;
    }

    public function check(): void
    {
        $method = $this->routes[$this->path_params['group']][$this->path_params['method']];
        $action = $method['actions'][$this->path_params['action']];

        if ($action === []) {
            throw new ApiException(
                ApiExceptionConstant::TYPE_METHOD_NOT_FOUND,
                'Method does not exist.',
                RequestConstant::CODE_NOT_FOUND
            );
        }

        if ($action['http_method'] !== $this->http_method) {
            header('Allow: '.$action['http_method']);

            throw new ApiException(
                ApiExceptionConstant::TYPE_HTTP_METHOD_NOT_ALLOWED,
                'Method '.$this->http_method.' not allowed for this endpoint.',
                RequestConstant::CODE_METHOD_NOT_ALLOWED
            );
        }

        if (!$method['active'] || !$action['active']) {
            throw new ApiException(
                ApiExceptionConstant::TYPE_METHOD_DISABLED,
                'Method is no longer available.',
                RequestConstant::CODE_GONE
            );
        }
    }
}