<?php

namespace Api\Handlers\Route;

final class RouteVersionFilterHandler
{
    private int $version;
    private string $group;
    private string $method;
    private string $action;
    /**
     * @var array<string, array<string, array{actions: array<string, array<int, array{version: int, http_method: string, access: int, wait_file: bool, no_auth: bool, deprecated: bool, active: bool}>>, active: bool}>>
     */
    private array $config_routes;

    /**
     * @param array{version: int, group: string, method: string, action: string, uid: string} $path_params
     * @param array<string, array<string, array{actions: array<string, array<int, array{version: int, http_method: string, access: int, wait_file: bool, no_auth: bool, deprecated: bool, active: bool}>>, active: bool}>> $config_routes
     */
    public function __construct(array $path_params, array $config_routes)
    {
        $this->version = $path_params['version'];
        $this->group = $path_params['group'];
        $this->method = $path_params['method'];
        $this->action = $path_params['action'];
        $this->config_routes = $config_routes;
    }

    /**
     * @return array<string, array<string, array{actions: array<string, array{version: int, http_method: string, access: int, wait_file: bool, no_auth: bool, deprecated: bool, active: bool}|array{}>, active: bool}>>
     */
    public function handle(): array
    {
        $versions = $this->config_routes[$this->group][$this->method]['actions'][$this->action];
        krsort($versions);

        $routes_filtered = [];
        $routes_filtered[$this->group][$this->method]['actions'][$this->action] = [];
        $routes_filtered[$this->group][$this->method]['active'] = $this->config_routes[$this->group][$this->method]['active'];

        foreach ($versions as $version) {
            if ($version['version'] <= $this->version) {
                $routes_filtered[$this->group][$this->method]['actions'][$this->action] = $version;
                break;
            }
        }

        return $routes_filtered;
    }
}