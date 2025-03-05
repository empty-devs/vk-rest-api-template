<?php

namespace Api\Middlewares\Route;

use Api\Constants\Http\RequestConstant;
use Api\Constants\Method\MethodConstant;
use Api\Constants\Route\RouteConstant;
use Api\Exceptions\ApiException;
use Api\Interfaces\Middleware\MiddlewareInterface;

final class RouteValidationMiddleware implements MiddlewareInterface
{
    /**
     * @var array{version: int, group: string, method: string, action: string, uid: string}
     */
    private array $path_params;

    /**
     * @param array{version: int, group: string, method: string, action: string, uid: string} $path_params
     */
    public function __construct(array $path_params)
    {
        $this->path_params = $path_params;
    }

    public function check(): void
    {
        if ($this->path_params['version'] === -1 || $this->path_params['group'] === '' ||
            $this->path_params['method'] === '' || $this->path_params['action'] === '') {
            throw new ApiException(
                'BAD_PATH_FORMAT',
                'URL does not contain enough parameters.',
                RequestConstant::CODE_BAD_REQUEST
            );
        }

        if (!in_array($this->path_params['version'], MethodConstant::AVAILABLE_VERSIONS, true)) {
            throw new ApiException(
                'VERSION_NOT_FOUND',
                'Version does not exist.',
                RequestConstant::CODE_NOT_FOUND
            );
        }

        if (!in_array($this->path_params['group'], RouteConstant::AVAILABLE_GROUPS, true)) {
            throw new ApiException(
                'ROUTE_NOT_FOUND',
                'Route does not exist.',
                RequestConstant::CODE_NOT_FOUND
            );
        }
    }
}