<?php

namespace Enes\LaravelPostgres\Schema;

use Closure;
use Illuminate\Database\Schema\PostgresBuilder;

class Builder extends PostgresBuilder
{
    /**
     * @param  string  $table
     * @return Blueprint
     */
    protected function createBlueprint($table, ?Closure $callback = null)
    {
        return new Blueprint($table, $callback);
    }
}
