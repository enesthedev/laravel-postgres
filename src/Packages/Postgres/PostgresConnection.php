<?php

namespace Enes\LaravelPostgres;

use Illuminate\Database\Grammar;
use Illuminate\Database\PostgresConnection as BasePostgresConnection;
use Illuminate\Database\Query\Processors\PostgresProcessor;

class PostgresConnection extends BasePostgresConnection
{
    /** @return Schema\Builder */
    public function getSchemaBuilder()
    {
        if ($this->schemaGrammar === null) {
            $this->useDefaultSchemaGrammar();
        }

        return new Schema\Builder($this);
    }

    /**
     * @info identical to parent method, can be safely dropped.
     *
     * @return PostgresProcessor
     */
    protected function getDefaultPostProcessor()
    {
        return new PostgresProcessor;
    }

    /** @return Grammar */
    protected function getDefaultSchemaGrammar()
    {
        return $this->withTablePrefix(new Schema\Grammars\PostgresGrammar);
    }
}
