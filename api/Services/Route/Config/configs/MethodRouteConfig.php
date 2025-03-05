<?php

namespace Api\Services\Route\Config\configs;

use Api\Interfaces\Service\Route\Config\configs\ActionsRouteConfigInterface;
use Api\Interfaces\Service\Route\Config\configs\MethodRouteConfigInterface;

final class MethodRouteConfig implements MethodRouteConfigInterface
{
    private ActionsRouteConfigInterface $actions_config;
    private bool $active = true;

    public function __construct(ActionsRouteConfigInterface $actions_config)
    {
        $this->actions_config = $actions_config;
    }

    public function setInactive(): void
    {
        $this->active = false;
    }

    /**
     * @return array{actions: array<string, array<int, array{version: int, http_method: string, access: int, wait_file: bool, no_auth: bool, deprecated: bool, active: bool}>>, active: bool}
     */
    public function toArray(): array
    {
        return [
            'actions' => $this->actions_config->toArray(),
            'active' => $this->active
        ];
    }
}
