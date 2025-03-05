<?php

namespace Api\Modules;

use Api\Constants\Exception\ApiExceptionConstant;
use Api\Constants\Http\RequestConstant;
use Api\Constants\Module\DatabaseConstant;
use Api\Exceptions\ApiException;
use PDO;
use PDOException;
use PDOStatement;
use RuntimeException;

final class DatabaseModule
{
    private static ?DatabaseModule $instance = null;
    private string $host;
    private string $name;
    private string $username;
    private string $password;
    private PDO $pdo;
    private bool $hasActiveTransaction = false;

    /**
     * @throws ApiException
     */
    private function __construct(string $host, string $name, string $username, string $password)
    {
        $this->host = $host;
        $this->name = $name;
        $this->username = $username;
        $this->password = $password;

        $this->connect();
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
     * @throws ApiException
     */
    private function connect(): void
    {
        $dsn = 'mysql:host='.$this->host.';dbname='.$this->name.';charset=utf8mb4';
        $opt = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_PERSISTENT => true
        ];

        try {
            $this->pdo = new PDO($dsn, $this->username, $this->password, $opt);
        } catch (PDOException $e) {
            throw new ApiException(
                ApiExceptionConstant::TYPE_INTERNAL_DATABASE,
                DatabaseConstant::TEXT_FAILED_CONNECT,
                RequestConstant::CODE_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * @throws ApiException
     */
    public static function getInstance(string $host, string $name, string $username, string $password): self
    {
        if (self::$instance === null) {
            self::$instance = new self($host, $name, $username, $password);
        }

        return self::$instance;
    }

    /**
     * @throws ApiException
     */
    public function query(string $sql): PDOStatement
    {
        try {
            $data = $this->pdo->query($sql);

            if ($data === false) {
                throw new ApiException(
                    ApiExceptionConstant::TYPE_INTERNAL_DATABASE,
                    DatabaseConstant::TEXT_FAILED_QUERY,
                    RequestConstant::CODE_INTERNAL_SERVER_ERROR
                );
            }

            return $data;
        } catch (PDOException $e) {
            throw new ApiException(
                ApiExceptionConstant::TYPE_INTERNAL_DATABASE,
                DatabaseConstant::TEXT_QUERY,
                RequestConstant::CODE_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * @param string $sql
     * @param array<string|int|float> $values
     * @return PDOStatement
     * @throws ApiException
     */
    public function execute(string $sql, array $values): PDOStatement
    {
        try {
            $data = $this->pdo->prepare($sql);

            if ($data === false) {
                throw new ApiException(
                    ApiExceptionConstant::TYPE_INTERNAL_DATABASE,
                    DatabaseConstant::TEXT_FAILED_EXECUTE_PREPARE,
                    RequestConstant::CODE_INTERNAL_SERVER_ERROR
                );
            }

            $execute = $data->execute($values);

            if ($execute === false) {
                throw new ApiException(
                    ApiExceptionConstant::TYPE_INTERNAL_DATABASE,
                    DatabaseConstant::TEXT_FAILED_EXECUTE,
                    RequestConstant::CODE_INTERNAL_SERVER_ERROR
                );
            }

            return $data;
        } catch (PDOException $e) {
            if ($this->hasActiveTransaction) {
                $this->rollbackTransaction();
            }

            throw new ApiException(
                ApiExceptionConstant::TYPE_INTERNAL_DATABASE,
                DatabaseConstant::TEXT_QUERY,
                RequestConstant::CODE_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * @throws ApiException
     */
    public function beginTransaction(): bool
    {
        try {
            $is_transaction = $this->pdo->beginTransaction();

            if (!$is_transaction) {
                throw new ApiException(
                    ApiExceptionConstant::TYPE_INTERNAL_DATABASE,
                    DatabaseConstant::TEXT_TRANSACTION_BEGIN,
                    RequestConstant::CODE_INTERNAL_SERVER_ERROR
                );
            }

            $this->hasActiveTransaction = true;
        } catch (PDOException $e) {
            throw new ApiException(
                ApiExceptionConstant::TYPE_INTERNAL_DATABASE,
                DatabaseConstant::TEXT_TRANSACTION,
                RequestConstant::CODE_INTERNAL_SERVER_ERROR
            );
        }

        return $is_transaction;
    }

    /**
     * @throws ApiException
     */
    public function commitTransaction(): bool
    {
        try {
            $is_commit = $this->pdo->commit();

            if (!$is_commit) {
                throw new ApiException(
                    ApiExceptionConstant::TYPE_INTERNAL_DATABASE,
                    DatabaseConstant::TEXT_TRANSACTION_COMMIT,
                    RequestConstant::CODE_INTERNAL_SERVER_ERROR
                );
            }

            $this->hasActiveTransaction = false;
        } catch (PDOException $e) {
            throw new ApiException(
                ApiExceptionConstant::TYPE_INTERNAL_DATABASE,
                DatabaseConstant::TEXT_TRANSACTION,
                RequestConstant::CODE_INTERNAL_SERVER_ERROR
            );
        }

        return $is_commit;
    }

    /**
     * @throws ApiException
     */
    public function rollbackTransaction(): bool
    {
        try {
            $is_rollback = $this->pdo->rollBack();

            if (!$is_rollback) {
                throw new ApiException(
                    ApiExceptionConstant::TYPE_INTERNAL_DATABASE,
                    DatabaseConstant::TEXT_TRANSACTION_ROLLBACK,
                    RequestConstant::CODE_INTERNAL_SERVER_ERROR
                );
            }

            $this->hasActiveTransaction = false;
        } catch (PDOException $e) {
            throw new ApiException(
                ApiExceptionConstant::TYPE_INTERNAL_DATABASE,
                DatabaseConstant::TEXT_TRANSACTION,
                RequestConstant::CODE_INTERNAL_SERVER_ERROR
            );
        }

        return $is_rollback;
    }

    public function getPdo(): PDO
    {
        return $this->pdo;
    }
}