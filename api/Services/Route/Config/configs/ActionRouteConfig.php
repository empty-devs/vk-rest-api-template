<?php

namespace Api\Services\Route\Config\configs;

use Api\Constants\UserConstant;
use Api\Interfaces\Service\Route\Config\configs\ActionRouteConfigInterface;

final class ActionRouteConfig implements ActionRouteConfigInterface
{
    private int $version;
    private string $http_method;
    private int $access = UserConstant::ACCESS_BASE;
    private bool $wait_file = false;
    private bool $no_auth = false;
    private bool $deprecated = false;
    private bool $active = true;

    public function __construct(int $version, string $http_method)
    {
        $this->version = $version;
        $this->http_method = $http_method;
    }

    public function setAccess(int $access): self
    {
        $this->access = $access;

        return $this;
    }

    public function setWaitFile(): self
    {
        $this->wait_file = true;

        return $this;
    }

    public function setNoAuth(): self
    {
        $this->no_auth = true;

        return $this;
    }

    public function setDeprecated(): void
    {
        $this->deprecated = true;
    }

    public function setInactive(): void
    {
        $this->active = false;
    }

    /**
     * @return array{version: int, http_method: string, access: int, wait_file: bool, no_auth: bool, deprecated: bool, active: bool}
     */
    public function toArray(): array
    {
        return [
            'version' => $this->version,
            'http_method' => $this->http_method,
            'access' => $this->access,
            'wait_file' => $this->wait_file,
            'no_auth' => $this->no_auth,
            'deprecated' => $this->deprecated,
            'active' => $this->active
        ];
    }
}
