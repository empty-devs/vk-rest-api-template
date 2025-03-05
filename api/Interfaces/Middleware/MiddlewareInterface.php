<?php

namespace Api\Interfaces\Middleware;

use Api\Exceptions\ApiException;

interface MiddlewareInterface
{
    /**
     * @throws ApiException
     */
    public function check(): void;
}