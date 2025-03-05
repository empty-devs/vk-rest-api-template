<?php

namespace Api\Handlers\Http\Request\queryParams;

use Api\Services\Route\Request\RouteRequest;

final class QueryParamsRequestHandle
{
    /**
     * @return array{uid: string}
     */
    public function handle(): array
    {
        $path_params = RouteRequest::getInstance()->getPathParams();

        if ($path_params['uid'] !== '') {
            return ['uid' => $path_params['uid']];
        }

        return ['uid' => ''];
    }
}