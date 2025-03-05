<?php

namespace Api\Scripts\Route;

require_once 'vendor/autoload.php';

use Api\Constants\Route\RouteConstant;
use Api\Interfaces\Script\Shared\BaseScript;
use Api\Loaders\RouteLoader;
use Api\Managers\RouteManager;
use Api\Services\Route\Config\RouteConfig;
use Api\Services\Route\Config\RouteMethodsConfig;
use RuntimeException;
use Throwable;

final class GenerateRouteCacheScript extends BaseScript
{
    public function make(): void
    {
        $route_groups = RouteConstant::AVAILABLE_GROUPS;

        $cache_dir = __DIR__.'/../../../caches/routes';

        foreach ($route_groups as $group) {
            echo 'Processing route group: '.$group.PHP_EOL;

            try {
                $route_methods_config = new RouteMethodsConfig($group);

                new RouteManager($route_methods_config);
                (new RouteLoader())->load($group);

                $routes = RouteConfig::getInstance()->toArray($route_methods_config);

                if (!is_dir($cache_dir) && !mkdir($cache_dir, 0777, true) && !is_dir($cache_dir)) {
                    throw new RuntimeException(sprintf('Directory "%s" was not created', $cache_dir));
                }

                $file_path = $cache_dir.'/'.$group.'.json';

                $put_file = file_put_contents(
                    $file_path,
                    json_encode($routes, JSON_THROW_ON_ERROR)
                );

                if ($put_file === false) {
                    echo 'Failed to create route group cache: '.$group.PHP_EOL;
                } else {
                    echo 'Route group cache created successfully: '.$group.PHP_EOL;
                }
            } catch (Throwable $e) {
                echo 'Error processing route group '.$group.': '.$e->getMessage().PHP_EOL;
            }
        }
    }
}

(new GenerateRouteCacheScript())->make();