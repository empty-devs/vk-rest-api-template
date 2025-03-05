<?php

namespace Api\Services\Route\Config;

use Api\Interfaces\Service\Route\Config\configs\ActionsRouteConfigInterface;
use Api\Interfaces\Service\Route\Config\RouteMethodsConfigInterface;
use Api\Services\Route\Config\configs\ActionsRouteConfig;
use Api\Services\Route\Config\configs\MethodRouteConfig;

final class RouteMethodsConfig implements RouteMethodsConfigInterface
{
    private string $group;
    /**
     * @var MethodRouteConfig[]
     */
    private array $methods = [];

    public function __construct(string $group)
    {
        $this->group = $group;
    }

    /**
     * @param string $name
     * @param callable(ActionsRouteConfigInterface $actions_config): void $actions
     * @return MethodRouteConfig
     */
    public function addMethod(string $name, callable $actions): MethodRouteConfig
    {
        $actions_config = new ActionsRouteConfig();
        $method_config = new MethodRouteConfig($actions_config);

        $this->methods[$name] = $method_config;

        $actions($actions_config);

        return $method_config;
    }

    public function getGroup(): string
    {
        return $this->group;
    }

    /**
     * @return MethodRouteConfig[]
     */
    public function getMethods(): array
    {
        return $this->methods;
    }
}