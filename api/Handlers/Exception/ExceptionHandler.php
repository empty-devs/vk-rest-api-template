<?php

namespace Api\Handlers\Exception;

use Api\Exceptions\ApiException;
use Api\Services\Http\Response\Response;
use ErrorException;
use Throwable;

final class ExceptionHandler
{
    public function handleException(Throwable $exception): void
    {
        if ($exception instanceof ApiException) {
            return;
        }

        $response = Response::getInstance();
        $response->setException($exception);

        echo $response->getJson();
    }

    /**
     * @throws ErrorException
     */
    public function handleError(int $err_no, string $err_str, string $err_file, int $err_line): bool
    {
        throw new ErrorException($err_str, 0, $err_no, $err_file, $err_line);
    }
}