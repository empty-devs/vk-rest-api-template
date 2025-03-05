<?php

namespace Api\Services\Container\Controller;

use Api\Interfaces\Controller\ControllerInterface;

final class ControllersContainer
{
    /**
     * @var ControllerInterface[]
     */
    private array $controllers = [];

    /**
     * @param ControllerInterface $controller
     * @return void
     */
    public function register(ControllerInterface $controller): void
    {
        $this->controllers[] = $controller;
    }

    /**
     * @return ControllerInterface[]
     */
    public function getControllers(): array
    {
        return $this->controllers;
    }
}