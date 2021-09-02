<?php

namespace JulesGraus\Actionlogs\Providers;

use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Events\Dispatcher;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use JulesGraus\Actionlogs\Services\ActionlogService;

class Events extends ServiceProvider
{
    private ActionlogService $actionlogService;

    public function __construct($app)
    {
        $this->actionlogService = new ActionlogService();
        parent::__construct($app);
    }

    /**
     * Register the listeners for the subscriber.
     */
    public function subscribe(Dispatcher $events): void
    {
        $events->listen(Login::class, fn(Login $event) => $this->actionlogService->log($event->user->email.' logged in'));
        $events->listen(Logout::class, fn(Logout $event) => $this->actionlogService->log('Someone logged out'));
        $events->listen(Failed::class, fn(Failed $event) => $this->actionlogService->log('Someone failed to login with email adres: '.$event->credentials['email'].'. Ip adres: '.request()->ip()));
        $events->listen(Lockout::class, fn(Lockout $event) => $this->actionlogService->log('Someone locked themselves out using ip address: '.request()->ip()));
        $events->listen(Registered::class, fn(Registered $event) => $this->actionlogService->log('Someone registered using email and ip address: '.$event->user->email.' ('.request()->ip().')'));
        $events->listen(PasswordReset::class, fn(PasswordReset $event) => $this->actionlogService->log($event->user->email.' did reset his password'));
        $events->listen(Verified::class, fn(Verified $event) => $this->actionlogService->log($event->user->email.' was verified successfully'));
    }
}
