<?php

namespace Api\Interfaces\Method\Shared;

use Api\Interfaces\Method\ApiMethodInterface;
use Api\Services\Http\Response\MethodResponse;

abstract class BaseMethod implements ApiMethodInterface
{
    /**
     * @var array<string, mixed>
     */
    protected array $params;
    protected MethodResponse $response;

    /**
     * @param array<string, mixed> $params
     * @param MethodResponse $response
     */
    public function __construct(array $params, MethodResponse $response)
    {
        $this->params = $params;
        $this->response = $response;
    }

    abstract public function main(): void;
}
