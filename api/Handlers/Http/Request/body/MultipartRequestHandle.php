<?php

namespace Api\Handlers\Http\Request\body;

final class MultipartRequestHandle
{
    /**
     * @return array<string, mixed>
     */
    public function handle(): array
    {
        $data = [];
        $data += $_FILES;
        $data += $_POST;

        return $data;
    }
}