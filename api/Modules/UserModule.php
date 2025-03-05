<?php

namespace Api\Modules;

use Api\Exceptions\ApiException;
use Api\Models\Database\tables\UserTable;
use RuntimeException;

final class UserModule
{
    private static ?UserModule $instance = null;
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

    /**
     * @throws ApiException
     */
    public function authorization(int $user_id): void
    {
        $this->data = (new UserTable())->getUserByUserId($user_id);
    }

    public function isAccess(int $access): bool
    {
        return $this->data['access'] >= $access;
    }

    public function isBlocking(): bool
    {
        return $this->data['blocking'] === 1;
    }

    /**
     * @return array<string, mixed>
     */
    public function getData(): array
    {
        return $this->data;
    }
}