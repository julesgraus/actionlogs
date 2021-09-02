<?php

namespace JulesGraus\Actionlogs\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use JulesGraus\Actionlogs\Contracts\Actionlog as ActionLogContract;
use JulesGraus\Actionlogs\Contracts\ActionlogPolicy as ActionlogPolicyContract;

class ActionlogAuth extends ServiceProvider
{
    /**
     * Get the policies.
     *
     * @return array
     */
    public function policies() {
        return [
            get_class(app(ActionLogContract::class)) => get_class(app(ActionlogPolicyContract::class))
        ];
    }

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
