<?php

namespace Api\Services\Http\Response;

final class MethodResponse
{
    /**
     * @var array<string, mixed>
     */
    private array $data = [];

    /**
     * @param array<string, mixed> $data
     * @return void
     */
    public function setData(array $data): void
    {
        $this->data = $data;
    }

    /**
     * @param array<string, mixed> $data
     * @return void
     */
    public function addData(array $data): void
    {
        $this->data += $data;
    }

    /**
     * @return array<string, mixed>
     */
    public function getData(): array
    {
        return $this->data;
    }
}