<?php

namespace Api\Interfaces\Service\Route\Config\configs;

interface MethodRouteConfigInterface
{
    public function __construct(ActionsRouteConfigInterface $actions_config);

    public function setInactive(): void;

    /**
     * @return array{actions: array<string, array<int, array{version: int, http_method: string, access: int, wait_file: bool, no_auth: bool, deprecated: bool, active: bool}>>, active: bool}
     */
    public function toArray(): array;
}