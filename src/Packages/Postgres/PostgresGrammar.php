<?php

namespace Enes\LaravelPostgres\Packages\Postgres;

use Doctrine\DBAL\Types\Type;
use Enes\LaravelPostgres\Schema\Blueprint;
use Illuminate\Database\Schema\Blueprint as BaseBlueprint;
use Illuminate\Support\Fluent;

class PostgresGrammar extends \Illuminate\Database\Schema\Grammars\PostgresGrammar
{
    public function compileCreate(BaseBlueprint $blueprint, Fluent $command)
    {
        $sql = parent::compileCreate($blueprint, $command);

        if (isset($blueprint->inherits)) {
            $sql .= ' INHERITS ("'.$blueprint->inherits.'")';
        }

        return $sql;
    }

    public function compileGin(Blueprint $blueprint, Fluent $command): string
    {
        $columns = $this->columnize($command->get('columns'));

        return sprintf(
            'CREATE INDEX %s ON %s USING GIN(%s)',
            $command->get('index'),
            $this->wrapTable($blueprint),
            $columns
        );
    }

    public function compileGist(Blueprint $blueprint, Fluent $command): string
    {
        $columns = $this->columnize($command->get('columns'));

        return sprintf(
            'CREATE INDEX %s ON %s USING GIST(%s)',
            $command->get('index'),
            $this->wrapTable($blueprint),
            $columns
        );
    }

    protected function getDefaultValue($value)
    {
        if (is_string($value) && $this->isUuid($value)) {
            return (string) $value;
        }

        return parent::getDefaultValue($value);
    }

    /**
     * @deprecated This method does not seem to exist in the parent class. I did find it in
     * \Illuminate\Database\Schema\Grammars\ChangeColumn however, which I suspect is what is intended.
     *
     * Further tests need to be made to be sure of what's going on here...
     */
    protected function getDoctrineColumnType($type): Type
    {
        return parent::getDoctrineColumnType($type);
    }

    protected function isUuid($value): bool
    {
        return str_starts_with($value, 'uuid_generate_v');
    }

    protected function typeBox(Fluent $column)
    {
        return 'box';
    }

    protected function typeCharacter(Fluent $column)
    {
        return "character({$column->length})";
    }

    protected function typeCircle(Fluent $column)
    {
        return 'circle';
    }

    protected function typeDaterange(Fluent $column)
    {
        return 'daterange';
    }

    protected function typeHstore(Fluent $column)
    {
        return 'hstore';
    }

    protected function typeInt4range(Fluent $column)
    {
        return 'int4range';
    }

    protected function typeInt8range(Fluent $column)
    {
        return 'int8range';
    }

    /** @info identical to parent method, can be safely dropped. */
    protected function typeIpAddress(Fluent $column)
    {
        return 'inet';
    }

    /** @info identical to parent method, can be safely dropped. */
    protected function typeJsonb(Fluent $column)
    {
        return 'jsonb';
    }

    protected function typeLine(Fluent $column)
    {
        return 'line';
    }

    protected function typeLineSegment(Fluent $column)
    {
        return 'lseg';
    }

    /** @info identical to parent method, can be safely dropped. */
    protected function typeMacAddress(Fluent $column)
    {
        return 'macaddr';
    }

    protected function typeMoney(Fluent $column)
    {
        return 'money';
    }

    protected function typeNetmask(Fluent $column)
    {
        return 'cidr';
    }

    protected function typeNumrange(Fluent $column)
    {
        return 'numrange';
    }

    protected function typePath(Fluent $column)
    {
        return 'path';
    }

    protected function typePoint(Fluent $column)
    {
        return 'point';
    }

    protected function typePolygon(Fluent $column)
    {
        return 'polygon';
    }

    protected function typeTsrange(Fluent $column)
    {
        return 'tsrange';
    }

    protected function typeTstzrange(Fluent $column)
    {
        return 'tstzrange';
    }

    protected function typeTsvector(Fluent $column)
    {
        return 'tsvector';
    }

    /** @info identical to parent method, can be safely dropped. */
    protected function typeUuid(Fluent $column)
    {
        return 'uuid';
    }
}
