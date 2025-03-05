<?php

namespace Api\Interfaces\Service\Route\Config;

use Api\Interfaces\Service\Route\Config\configs\ActionsRouteConfigInterface;
use Api\Services\Route\Config\configs\MethodRouteConfig;

interface RouteMethodsConfigInterface
{
    public function __construct(string $group);

    /**
     * @param string $name
     * @param callable(ActionsRouteConfigInterface $actions_config): void $actions
     * @return MethodRouteConfig
     */
    public function addMethod(string $name, callable $actions): MethodRouteConfig;

    public function getGroup(): string;

    /**
     * @return MethodRouteConfig[]
     */
    public function getMethods(): array;
}