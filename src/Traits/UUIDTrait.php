<?php

namespace Enes\LaravelPostgres\Traits;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;
use RuntimeException;

trait UUIDTrait
{
    protected static function bootUUIDTrait(): void
    {
        static::creating(function (Model $model): void {
            $this->provideUUIDKey($model);
        });
    }

    protected function provideUUIDKey(Model $model): void
    {
        if ($model->incrementing === false) {
            $key = $model->getKeyName();

            if (empty($model->getAttribute($key))) {
                $model->{$key} = (string) Uuid::uuid4();
            }
        } else {
            throw new RuntimeException(
                sprintf(
                    '$incrementing must be false on class "%s" to support uuid',
                    static::class
                )
            );
        }
    }
}
