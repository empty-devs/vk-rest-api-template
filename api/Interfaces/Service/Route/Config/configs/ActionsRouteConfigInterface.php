<?php

namespace Api\Interfaces\Service\Route\Config\configs;

use Api\Services\Route\Config\configs\ActionRouteConfig;

interface ActionsRouteConfigInterface
{
    public function POST(string $name, int $version): ActionRouteConfig;

    public function GET(string $name, int $version): ActionRouteConfig;

    public function PATCH(string $name, int $version): ActionRouteConfig;

    public function DELETE(string $name, int $version): ActionRouteConfig;

    public function PUT(string $name, int $version): ActionRouteConfig;

    /**
     * @return array<string, array<int, array{version: int, http_method: string, access: int, wait_file: bool, no_auth: bool, deprecated: bool, active: bool}>>
     */
    public function toArray(): array;
}