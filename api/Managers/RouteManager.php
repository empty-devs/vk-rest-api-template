<?php

namespace Api\Managers;

use Api\Interfaces\Service\Route\Config\configs\ActionsRouteConfigInterface;
use Api\Interfaces\Service\Route\Config\configs\MethodRouteConfigInterface;
use Api\Interfaces\Service\Route\Config\RouteMethodsConfigInterface;

final class RouteManager
{
    private static RouteMethodsConfigInterface $route_methods_config;

    public function __construct(RouteMethodsConfigInterface $route_methods_config)
    {
        self::$route_methods_config = $route_methods_config;
    }

    /**
     * @param string $name
     * @param callable(ActionsRouteConfigInterface $actions_config): void $actions
     * @return MethodRouteConfigInterface
     */
    public static function addMethod(string $name, callable $actions): MethodRouteConfigInterface
    {
        return self::$route_methods_config->addMethod($name, $actions);
    }
}