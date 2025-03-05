<?php

namespace Api\Services\Route\Request;

use Api\Constants\Route\RouteConstant;
use Api\Services\Route\Request\structures\PathParamsStructure;
use RuntimeException;

final class RouteRequest
{
    private static ?RouteRequest $instance = null;
    private PathParamsStructure $path_params;

    private function __construct()
    {
        $this->path_params = new PathParamsStructure();
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

    public function initPathParams(string $uri): void
    {
        $url_path = parse_url($uri, PHP_URL_PATH);

        if (!is_string($url_path)) {
            return;
        }

        $pattern = '#^/api/v(?P<version>\d+)(?:/(?P<group>[a-z]+))?/(?P<method>[a-z]+)\.(?P<action>[a-z]+)(?:/(?P<uid>[a-z0-9]+))?$#';

        if (preg_match($pattern, $url_path, $matches) === 1) {
            $this->path_params = new PathParamsStructure(
                (int)$matches['version'],
                $matches['group'] !== '' ? $matches['group'] : RouteConstant::GROUP_BASE,
                $matches['method'],
                $matches['action'],
                $matches['uid'] ?? ''
            );
        }
    }

    /**
     * @return array{version: int, group: string, method: string, action: string, uid: string}
     */
    public function getPathParams(): array
    {
        return $this->path_params->toArray();
    }
}