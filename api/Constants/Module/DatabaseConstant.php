<?php

namespace Api\Constants\Module;

interface DatabaseConstant
{
    public const TEXT_FAILED_CONNECT = 'Failed to connect to database.';
    public const TEXT_QUERY = 'Something happened to the database query.';
    public const TEXT_FAILED_QUERY = 'Failed to query.';
    public const TEXT_FAILED_EXECUTE_PREPARE = 'Failed to query (prepare).';
    public const TEXT_FAILED_EXECUTE = 'Failed to query (execute).';
    public const TEXT_TRANSACTION = 'Something happened to the database transaction.';
    public const TEXT_TRANSACTION_BEGIN = 'Failed to begin transaction.';
    public const TEXT_TRANSACTION_COMMIT = 'Failed to commit transaction.';
    public const TEXT_TRANSACTION_ROLLBACK = 'Failed to rollback transaction';
}