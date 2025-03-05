<?php

namespace Api\Services\Route\Request\structures;

final class PathParamsStructure
{
    private int $version;
    private string $group;
    private string $method;
    private string $action;
    private string $uid;

    public function __construct(
        int    $version = -1,
        string $group = '',
        string $method = '',
        string $action = '',
        string $uid = ''
    )
    {
        $this->version = $version;
        $this->group = $group;
        $this->method = $method;
        $this->action = $action;
        $this->uid = $uid;
    }

    /**
     * @return array{version: int, group: string, method: string, action: string, uid: string}
     */
    public function toArray(): array
    {
        return [
            'version' => $this->version,
            'group' => $this->group,
            'method' => $this->method,
            'action' => $this->action,
            'uid' => $this->uid
        ];
    }
}