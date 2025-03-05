<?php

namespace Api;

use Api\Configs\SystemConfig;
use Api\Constants\Http\RequestConstant;
use Api\Controllers\ApiController;
use Api\Controllers\MethodController;
use Api\Controllers\RouteController;
use Api\Handlers\Exception\ExceptionHandler;
use Api\Loaders\ConfigLoader;
use Api\Services\Container\Controller\ControllersContainer;
use Api\Services\Http\Request\Request;
use Api\Services\Http\Response\Response;

final class Core
{
    public function __construct()
    {
        $this->init();
    }

    private function init(): void
    {
        $this->initException();
        $this->initConfig();

        if (in_array(Request::getHttpMethod(), RequestConstant::METHODS_NOT_ALLOWED, true)) {
            return;
        }

        if (SystemConfig::isMaintenanceMode()) {
            $response = Response::getInstance();
            $response->setMaintenance();

            echo $response->getJson();

            return;
        }

        $this->initController();
    }

    private function initException(): void
    {
        $exception_handler = new ExceptionHandler();

        set_exception_handler([$exception_handler, 'handleException']);
        set_error_handler([$exception_handler, 'handleError']);
    }

    private function initConfig(): void
    {
        (new ConfigLoader())->load();
    }

    private function initController(): void
    {
        $controllers_container = new ControllersContainer();

        $controllers_container->register(new RouteController());
        $controllers_container->register(new MethodController());

        $api_controller = new ApiController($controllers_container);
        $api_controller->make();
    }
}