<?php

namespace Enes\LaravelPostgres\Connectors;

use Enes\LaravelPostgres\PostgresConnection;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\ConnectionInterface;
use InvalidArgumentException;
use PDO;

class ConnectionFactory extends \Illuminate\Database\Connectors\ConnectionFactory
{
    /**
     * @param  string  $driver
     * @param  PDO  $connection
     * @param  string  $database
     * @param  string  $prefix
     * @return ConnectionInterface
     *
     * @throws InvalidArgumentException|BindingResolutionException
     */
    protected function createConnection($driver, $connection, $database, $prefix = '', array $config = []): PostgresConnection|ConnectionInterface
    {
        if ($this->container->bound($key = "db.connection.{$driver}")) {
            return $this->container->make($key, [$connection, $database, $prefix, $config]);
        }

        if ($driver === 'pgsql') {
            return new PostgresConnection($connection, $database, $prefix, $config);
        }

        return parent::createConnection($driver, $connection, $database, $prefix, $config);
    }
}
