<?php

namespace Api\Interfaces\Controller;

use Api\Exceptions\ApiException;

interface ControllerInterface
{
    /**
     * @throws ApiException
     */
    public function handle(): void;
}