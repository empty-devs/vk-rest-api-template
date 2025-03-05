<?php

namespace Api\Models\Database;

use Api\Configs\DataBaseConfig;
use Api\Exceptions\ApiException;
use Api\Modules\DatabaseModule;
use PDOStatement;

abstract class DatabaseModel
{
    protected DatabaseModule $database_module;
    protected string $table_name;

    /**
     * @throws ApiException
     */
    public function __construct()
    {
        $this->database_module = DatabaseModule::getInstance(
            DataBaseConfig::getHost(),
            DataBaseConfig::getName(),
            DataBaseConfig::getUsername(),
            DataBaseConfig::getPassword()
        );
    }

    /**
     * @param string $columns
     * @param string $data
     * @param array<string|int|float> $values
     * @return int
     * @throws ApiException
     */
    public function add(string $columns, string $data, array $values): int
    {
        return $this->database_module->execute(
            'INSERT INTO '.$this->table_name.' ('.$columns.') VALUES ('.$data.')',
            $values
        )->rowCount();
    }

    /**
     * @param string $columns
     * @return PDOStatement
     * @throws ApiException
     */
    public function get(string $columns): PDOStatement
    {
        return $this->database_module->query('SELECT '.$columns.' FROM '.$this->table_name);
    }

    /**
     * @param string $columns
     * @param string $options
     * @param array<string|int|float> $values
     * @return PDOStatement
     * @throws ApiException
     */
    public function getWhere(string $columns, string $options, array $values): PDOStatement
    {
        return $this->database_module->execute(
            'SELECT '.$columns.' FROM '.$this->table_name.' WHERE '.$options,
            $values
        );
    }

    /**
     * @param string $data
     * @param string $options
     * @param array<string|int|float> $values
     * @return int
     * @throws ApiException
     */
    public function edit(string $data, string $options, array $values): int
    {
        return $this->database_module->execute(
            'UPDATE '.$this->table_name.' SET '.$data.' WHERE '.$options,
            $values
        )->rowCount();
    }

    /**
     * @param string $options
     * @param array<string|int|float> $values
     * @return int
     * @throws ApiException
     */
    public function delete(string $options, array $values): int
    {
        return $this->database_module->execute(
            'DELETE FROM '.$this->table_name.' WHERE '.$options,
            $values
        )->rowCount();
    }
}