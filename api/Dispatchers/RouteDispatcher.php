<?php

namespace Api\Dispatchers;

use Api\Caches\RouteCache;
use Api\Configs\RouteCacheConfig;
use Api\Loaders\RouteLoader;
use Api\Managers\RouteManager;
use Api\Services\Route\Config\RouteConfig;
use Api\Services\Route\Config\RouteMethodsConfig;

final class RouteDispatcher
{
    private string $group;

    public function __construct(string $group)
    {
        $this->group = $group;
    }

    /**
     * @return array<string, array<string, array{actions: array<string, array<int, array{version: int, http_method: string, access: int, wait_file: bool, no_auth: bool, deprecated: bool, active: bool}>>, active: bool}>>
     */
    public function get(): array
    {
        if (RouteCacheConfig::isCacheMode()) {
            $routes = $this->getRoutesCache();

            if ($routes !== []) {
                return $routes;
            }
        }

        return $this->getRoutes();
    }

    /**
     * @return array<string, array<string, array{actions: array<string, array<int, array{version: int, http_method: string, access: int, wait_file: bool, no_auth: bool, deprecated: bool, active: bool}>>, active: bool}>>
     */
    private function getRoutesCache(): array
    {
        return (new RouteCache($this->group))->getFileData();
    }

    /**
     * @return array<string, array<string, array{actions: array<string, array<int, array{version: int, http_method: string, access: int, wait_file: bool, no_auth: bool, deprecated: bool, active: bool}>>, active: bool}>>
     */
    private function getRoutes(): array
    {
        $route_methods_config = new RouteMethodsConfig($this->group);
        new RouteManager($route_methods_config);
        (new RouteLoader())->load($this->group);

        return RouteConfig::getInstance()->toArray($route_methods_config);
    }
}