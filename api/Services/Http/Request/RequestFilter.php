<?php

namespace Api\Services\Http\Request;

use RuntimeException;

final class RequestFilter
{
    private function __construct()
    {
    }

    private function __clone()
    {
    }

    /**
     * @throws RuntimeException
     */
    public function __wakeup()
    {
        throw new RuntimeException();
    }

    /**
     * @param array<string, mixed> $request_params
     * @param array<string, mixed> $params
     * @return array<string, mixed>
     */
    public static function params(array $request_params, array $params): array
    {
        return array_intersect_key($request_params, $params);
    }
}