<?php

namespace JulesGraus\Actionlogs\Providers;

use Illuminate\Support\ServiceProvider;
use JulesGraus\Actionlogs\Models\Actionlog as ActionlogModel;
use JulesGraus\Actionlogs\Policies\Actionlog as ActionlogPolicy;
use JulesGraus\Actionlogs\Services\ActionlogService;
use JulesGraus\Actionlogs\Resources\Actionlog as ActionLogResource;
use JulesGraus\Actionlogs\Resources\ActionlogCollection;
use JulesGraus\Actionlogs\Contracts\Actionlog as ActionlogContract;
use JulesGraus\Actionlogs\Contracts\ActionlogPolicy as ActionlogPolicyContract;
use JulesGraus\Actionlogs\Contracts\ActionlogCollection as ActionlogResourceCollectionContract;
use JulesGraus\Actionlogs\Contracts\ActionlogResource as ActionlogResourceContract;
use JulesGraus\Housekeeper\Housekeeper;

class Actionlog extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ActionlogContract::class, ActionlogModel::class);
        $this->app->bind(ActionlogPolicyContract::class, ActionlogPolicy::class);
        $this->app->bind(ActionlogResourceContract::class, fn() => ActionLogResource::class);
        $this->app->bind(ActionlogResourceCollectionContract::class, fn() => ActionlogCollection::class);

        Housekeeper::register([ActionlogService::class]);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $packageRoot = __DIR__.'/../../';
        $this->loadTranslationsFrom($packageRoot. 'resources/lang', 'actionlogs');
        $this->loadMigrationsFrom($packageRoot.'database/migrations');

        $this->publishes([
            $packageRoot . 'config/' => config_path(),
            $packageRoot . 'resources/' => resource_path(),
        ], 'actionlogs');
    }
}
