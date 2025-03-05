<?php

declare(strict_types=1);

namespace Tests\Route\Config;

use Api\Managers\RouteManager;
use Api\Services\Route\Config\RouteConfig;
use Api\Services\Route\Config\RouteMethodsConfig;
use PHPUnit\Framework\TestCase;
use RuntimeException;

final class RouteConfigTest extends TestCase
{
    public function testRouteConfigArrayStructure(): void
    {
        $route_methods_config = new RouteMethodsConfig('main');

        new RouteManager($route_methods_config);

        $file_path = __DIR__.'/routes/main.php';

        if (!file_exists($file_path)) {
            throw new RuntimeException('File path '.$file_path.' not found!');
        }

        require $file_path;

        $routes = RouteConfig::getInstance()->toArray($route_methods_config);

        $correct_routes_structure = [
            'main' => [
                'test' => [
                    'actions' => [
                        'start' => [
                            1 => [
                                'version' => 1,
                                'http_method' => 'GET',
                                'access' => 0,
                                'wait_file' => false,
                                'no_auth' => false,
                                'deprecated' => false,
                                'active' => false
                            ]
                        ]
                    ],
                    'active' => true
                ]
            ]
        ];

        $this->assertSame(
            $routes,
            $correct_routes_structure,
            'Массив не соответствует ожидаемой структуре.'
        );
    }
}
