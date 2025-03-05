<?php

namespace Api\Exceptions;

use Exception;
use Throwable;

final class ApiException extends Exception
{
    private string $description;
    private int $http_code;
    /**
     * @var array<string, mixed>
     */
    private array $details;

    /**
     * @param string $type
     * @param string $description
     * @param int $http_code
     * @param array<string, mixed> $details
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(
        string    $type,
        string    $description,
        int       $http_code,
        array     $details = [],
        int       $code = 0,
        Throwable $previous = null
    )
    {
        parent::__construct($type, $code, $previous);

        $this->description = $description;
        $this->http_code = $http_code;
        $this->details = $details;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getHttpCode(): int
    {
        return $this->http_code;
    }

    /**
     * @return array<string, mixed>
     */
    public function getDetails(): array
    {
        return $this->details;
    }
}