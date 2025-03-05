<?php

namespace Api\Controllers;

use Api\Dispatchers\RouteDispatcher;
use Api\Handlers\Route\RouteVersionFilterHandler;
use Api\Interfaces\Controller\ControllerInterface;
use Api\Middlewares\Route\Method\RouteMethodActionValidationMiddleware;
use Api\Middlewares\Route\Method\RouteMethodValidationMiddleware;
use Api\Middlewares\Route\RouteValidationMiddleware;
use Api\Services\Http\Request\Request;
use Api\Services\Route\Config\RouteConfig;
use Api\Services\Route\Request\RouteRequest;

final class RouteController implements ControllerInterface
{
    public function handle(): void
    {
        $route_request = RouteRequest::getInstance();
        $route_request->initPathParams(Request::getURI());
        $path_params = $route_request->getPathParams();

        (new RouteValidationMiddleware($path_params))->check();

        $routes = (new RouteDispatcher($path_params['group']))->get();

        $middleware = new RouteMethodValidationMiddleware($path_params, $routes);
        $middleware->check();

        $routes = (new RouteVersionFilterHandler($path_params, $routes))->handle();

        $middleware = new RouteMethodActionValidationMiddleware(Request::getHttpMethod(), $path_params, $routes);
        $middleware->check();

        RouteConfig::getInstance()->setRoutesFiltered($routes);
    }
}