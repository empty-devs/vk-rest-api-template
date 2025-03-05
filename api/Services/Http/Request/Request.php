<?php

namespace Api\Services\Http\Request;

use RuntimeException;

final class Request
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
     * @return array<string, mixed>
     */
    public static function getAllHeaders(): array
    {
        $headers = getallheaders();

        return count($headers) > 0 ? $headers : [];
    }

    public static function getURI(): string
    {
        return $_SERVER['REQUEST_URI'] ?? '';
    }

    public static function getHttpMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'] ?? '';
    }

    public static function getContentType(): string
    {
        return $_SERVER['CONTENT_TYPE'] ?? '';
    }
}