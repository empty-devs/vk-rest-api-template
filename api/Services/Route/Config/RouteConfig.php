<?php

namespace Api\Services\Route\Config;

use Api\Interfaces\Service\Route\Config\RouteMethodsConfigInterface;
use RuntimeException;

final class RouteConfig
{
    private static ?RouteConfig $instance = null;
    /**
     * @var array<string, array<string, array{actions: array<string, array{version: int, http_method: string, access: int, wait_file: bool, no_auth: bool, deprecated: bool, active: bool}>, active: bool}>>
     */
    private array $routes_filtered = [];

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    /**
     * @throws RuntimeException
     */
    public function __wakeup()
    {
        throw new RuntimeException();
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @param array<string, array<string, array{actions: array<string, array{version: int, http_method: string, access: int, wait_file: bool, no_auth: bool, deprecated: bool, active: bool}>, active: bool}>> $routes_filtered
     * @return void
     */
    public function setRoutesFiltered(array $routes_filtered): void
    {
        $this->routes_filtered = $routes_filtered;
    }

    /**
     * @param string $group
     * @param string $method
     * @param string $action
     * @return array{version: int, http_method: string, access: int, wait_file: bool, no_auth: bool, deprecated: bool, active: bool}
     */
    public function getMethodAction(string $group, string $method, string $action): array
    {
        return $this->routes_filtered[$group][$method]['actions'][$action];
    }

    /**
     * @param RouteMethodsConfigInterface $route_configs
     * @return array<string, array<string, array{actions: array<string, array<int, array{version: int, http_method: string, access: int, wait_file: bool, no_auth: bool, deprecated: bool, active: bool}>>, active: bool}>>
     */
    public function toArray(RouteMethodsConfigInterface $route_configs): array
    {
        $routes = [];

        foreach ($route_configs->getMethods() as $method_name => $method) {
            $group = $route_configs->getGroup();
            $routes[$group][$method_name] = $method->toArray();
        }

        return $routes;
    }
}