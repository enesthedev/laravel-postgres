<?php

namespace Enes\LaravelPostgres\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Enes Bayraktar\LaravelPostgres\LaravelPostgres
 */
class LaravelPostgres extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Enes\LaravelPostgres\LaravelPostgres::class;
    }
}
