<?php

namespace Api\Caches;

use JsonException;

final class RouteCache
{
    private string $group;

    public function __construct(string $group)
    {
        $this->group = $group;
    }

    /**
     * @return array<string, array<string, array{actions: array<string, array<int, array{version: int, http_method: string, access: int, wait_file: bool, no_auth: bool, deprecated: bool, active: bool}>>, active: bool}>>
     */
    public function getFileData(): array
    {
        $cache_dir = __DIR__.'/../../caches/routes/';
        $file_path = $cache_dir.$this->group.'.json';

        if (file_exists($file_path)) {
            try {
                $routes_json = file_get_contents($file_path);

                if ($routes_json === false) {
                    return [];
                }

                $routes_array = json_decode($routes_json, true, 512, JSON_THROW_ON_ERROR);

                if (is_array($routes_array)) {
                    return $routes_array;
                }

                return [];
            } catch (JsonException $e) {
                return [];
            }
        }

        return [];
    }
}