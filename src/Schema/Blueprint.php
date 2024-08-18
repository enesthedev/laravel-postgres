<?php

namespace Enes\LaravelPostgres\Schema;

use Illuminate\Support\Fluent;

class Blueprint extends \Illuminate\Database\Schema\Blueprint
{
    public string $inherits;

    public function box(string $column): Fluent
    {
        return $this->addColumn('box', $column);
    }

    public function character(string $column, int $length = 255): Fluent
    {
        return $this->addColumn('character', $column, compact('length'));
    }

    public function circle(string $column): Fluent
    {
        return $this->addColumn('circle', $column);
    }

    public function daterange(string $column): Fluent
    {
        return $this->addColumn('daterange', $column);
    }

    public function gin(array|string $columns, ?string $name = null): Fluent
    {
        return $this->indexCommand('gin', $columns, $name);
    }

    public function gist(array|string $columns, ?string $name = null): Fluent
    {
        return $this->indexCommand('gist', $columns, $name);
    }

    public function hstore(string $column): Fluent
    {
        return $this->addColumn('hstore', $column);
    }

    public function inherits(string $table): void
    {
        $this->inherits = $table;
    }

    public function int4range(string $column): Fluent
    {
        return $this->addColumn('int4range', $column);
    }

    public function int8range(string $column): Fluent
    {
        return $this->addColumn('int8range', $column);
    }

    public function line(string $column): Fluent
    {
        return $this->addColumn('line', $column);
    }

    public function lineSegment(string $column): Fluent
    {
        return $this->addColumn('lineSegment', $column);
    }

    public function money(string $column): Fluent
    {
        return $this->addColumn('money', $column);
    }

    public function netmask(string $column): Fluent
    {
        return $this->addColumn('netmask', $column);
    }

    public function numrange(string $column): Fluent
    {
        return $this->addColumn('numrange', $column);
    }

    public function path(string $column): Fluent
    {
        return $this->addColumn('path', $column);
    }

    public function tsrange(string $column): Fluent
    {
        return $this->addColumn('tsrange', $column);
    }

    public function tstzrange(string $column): Fluent
    {
        return $this->addColumn('tstzrange', $column);
    }

    public function tsvector(string $column): Fluent
    {
        return $this->addColumn('tsvector', $column);
    }

    protected function addFluentIndexes(\Illuminate\Database\Connection $connection, \Illuminate\Database\Schema\Grammars\Grammar $grammar): void
    {
        foreach ($this->columns as $column) {
            foreach (['primary', 'unique', 'index', 'gin', 'gist'] as $index) {

                // If the index has been specified on the given column, but is simply
                // equal to "true" (boolean), no name has been specified for this
                // index, so we will simply call the index methods without one.
                if ($column->get($index) === true) {
                    $this->{$index}($column->get('name'));

                    continue 2;
                }

                // If the index has been specified on the column and it is something
                // other than boolean true, we will assume a name was provided on
                // the index specification, and pass in the name to the method.
                if ($column->get($index) !== null) {
                    $this->{$index}($column->get('name'), $column->get($index));

                    continue 2;
                }
            }
        }
    }
}
