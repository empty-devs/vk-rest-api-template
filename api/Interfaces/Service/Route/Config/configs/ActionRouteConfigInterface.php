<?php

namespace Api\Interfaces\Service\Route\Config\configs;

interface ActionRouteConfigInterface
{
    public function __construct(int $version, string $http_method);

    public function setAccess(int $access): self;

    public function setWaitFile(): self;

    public function setNoAuth(): self;

    public function setDeprecated(): void;

    public function setInactive(): void;

    /**
     * @return array{version: int, http_method: string, access: int, wait_file: bool, no_auth: bool, deprecated: bool, active: bool}
     */
    public function toArray(): array;
}