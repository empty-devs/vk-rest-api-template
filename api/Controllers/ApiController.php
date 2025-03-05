<?php

namespace Api\Controllers;

use Api\Exceptions\ApiException;
use Api\Interfaces\Controller\ControllerInterface;
use Api\Services\Container\Controller\ControllersContainer;
use Api\Services\Http\Response\Response;

final class ApiController
{
    /**
     * @var ControllerInterface[]
     */
    private array $controllers_container;

    public function __construct(ControllersContainer $controllers_container)
    {
        $this->controllers_container = $controllers_container->getControllers();
    }

    public function make(): void
    {
        $response = Response::getInstance();

        try {
            foreach ($this->controllers_container as $controller) {
                $controller->handle();
            }

            echo $response->getJson();
        } catch (ApiException $e) {
            $response->setApiException(
                $e->getMessage(),
                $e->getDescription(),
                $e->getHttpCode(),
                $e->getDetails()
            );

            echo $response->getJson();
        }
    }
}