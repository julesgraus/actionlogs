<?php

namespace JulesGraus\Actionlogs\Tests;

use JulesGraus\Actionlogs\Providers\ActionlogAuth;
use JulesGraus\Actionlogs\Providers\Actionlog;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            ActionlogAuth::class,
            Actionlog::class
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function defineEnvironment($app)
    {
        $app['config']->set('debug', true);

        $app['config']->set('actionlogs.prefix', 'actionlogs');
        $app['config']->set('actionlogs.middleware', '');

        // Setup default database to use sqlite :memory:`
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    /**
     * Define Database Migrations.
     *
     * @return void
     */
    protected function defineDatabaseMigrations()
    {
        $this->loadMigrationsFrom(realpath(__DIR__ . '/../database/migrations'));
        $this->loadMigrationsFrom(realpath(__DIR__ . '/Database/Migrations'));
    }
}
