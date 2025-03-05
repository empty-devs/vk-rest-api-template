<?php

namespace Api\Services\Route\Config\configs;

use Api\Constants\Http\RequestConstant;
use Api\Interfaces\Service\Route\Config\configs\ActionsRouteConfigInterface;

final class ActionsRouteConfig implements ActionsRouteConfigInterface
{
    /**
     * @var ActionRouteConfig[][]
     */
    private array $actions = [];

    private function addAction(int $version, string $name, string $http_method): ActionRouteConfig
    {
        $action_config = new ActionRouteConfig($version, $http_method);
        $this->actions[$name][$version] = $action_config;

        return $action_config;
    }

    public function POST(string $name, int $version): ActionRouteConfig
    {
        return $this->addAction($version, $name, RequestConstant::METHOD_POST);
    }

    public function GET(string $name, int $version): ActionRouteConfig
    {
        return $this->addAction($version, $name, RequestConstant::METHOD_GET);
    }

    public function PATCH(string $name, int $version): ActionRouteConfig
    {
        return $this->addAction($version, $name, RequestConstant::METHOD_PATCH);
    }

    public function DELETE(string $name, int $version): ActionRouteConfig
    {
        return $this->addAction($version, $name, RequestConstant::METHOD_DELETE);
    }

    public function PUT(string $name, int $version): ActionRouteConfig
    {
        return $this->addAction($version, $name, RequestConstant::METHOD_PUT);
    }

    /**
     * @return array<string, array<int, array{version: int, http_method: string, access: int, wait_file: bool, no_auth: bool, deprecated: bool, active: bool}>>
     */
    public function toArray(): array
    {
        $actions_array = [];

        foreach ($this->actions as $name => $versions) {
            foreach ($versions as $version => $config) {
                $actions_array[$name][$version] = $config->toArray();
            }
        }

        return $actions_array;
    }
}