<?php

namespace Enes\LaravelPostgres;

use Enes\LaravelPostgres\Connectors\ConnectionFactory;
use Illuminate\Database\DatabaseManager;
use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelPostgresServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-postgres');
    }

    /**
     * @throws InvalidPackage
     */
    public function register()
    {
        return parent::register();

        $this->app->singleton('db.factory', fn ($app) => new ConnectionFactory($app));
        $this->app->singleton('db', fn ($app) => new DatabaseManager($app, $app['db.factory']));
    }
}
