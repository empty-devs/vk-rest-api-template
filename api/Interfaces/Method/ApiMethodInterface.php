<?php

namespace Api\Interfaces\Method;

use Api\Services\Http\Response\MethodResponse;

interface ApiMethodInterface
{
    /**
     * @param array<string, mixed> $params
     * @param MethodResponse $response
     */
    public function __construct(array $params, MethodResponse $response);

    public function main(): void;
}