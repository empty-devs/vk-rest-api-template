<?php

namespace Api\Services\Http\Response;

use Api\Constants\Exception\ExceptionConstant;
use Api\Constants\Http\RequestConstant;
use Api\Constants\SystemConstant;
use JsonException;
use RuntimeException;
use Throwable;

final class Response
{
    private static ?Response $instance = null;
    /**
     * @var array<string, mixed>
     */
    private array $data = [];

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

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function httpCode(int $http_code): void
    {
        http_response_code($http_code);
    }

    public function header(string $header, bool $replace = true, int $response_code = 0): void
    {
        header($header, $replace, $response_code);
    }

    public function setMaintenance(): void
    {
        $this->httpCode(RequestConstant::CODE_SERVICE_UNAVAILABLE);
        $this->header('Retry-After: 3600');

        $this->data = [
            'error' => [
                'type' => SystemConstant::TYPE_MAINTENANCE,
                'description' => 'Service is temporarily unavailable due to maintenance.',
                'details' => []
            ],
            'success' => false,
            'http_code' => RequestConstant::CODE_SERVICE_UNAVAILABLE
        ];
    }

    /**
     * @param array<string, mixed> $data
     * @param int $version
     * @param bool $deprecated
     * @return void
     */
    public function setMethod(array $data, int $version, bool $deprecated): void
    {
        $this->httpCode(RequestConstant::CODE_OK);

        $this->data = [
            'success' => count($data) > 0,
            'data' => $data,
            'version' => $version,
            'deprecated' => $deprecated,
            'http_code' => RequestConstant::CODE_OK
        ];
    }

    /**
     * @param string $type
     * @param string $description
     * @param int $http_code
     * @param array<string, mixed> $details
     * @return void
     */
    public function setApiException(
        string $type,
        string $description,
        int    $http_code,
        array  $details
    ): void
    {
        $this->httpCode($http_code);

        $this->data = [
            'error' => [
                'type' => $type,
                'description' => $description,
                'details' => $details
            ],
            'success' => false,
            'http_code' => $http_code
        ];
    }

    public function setException(Throwable $exception): void
    {
        $this->httpCode(RequestConstant::CODE_INTERNAL_SERVER_ERROR);

        $this->data = [
            'error' => [
                'type' => ExceptionConstant::TYPE_INTERNAL_SERVER,
                'description' => $exception->getMessage(),
                'details' => []
            ],
            'success' => false,
            'http_code' => RequestConstant::CODE_INTERNAL_SERVER_ERROR
        ];
    }

    public function getJson(): string
    {
        $this->header('Content-Type: application/json; charset=utf-8');

        try {
            return json_encode($this->data, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            return '{}';
        }
    }
}