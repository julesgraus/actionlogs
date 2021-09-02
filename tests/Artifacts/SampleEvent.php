<?php

namespace JulesGraus\Actionlogs\Tests\Artifacts;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SampleEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The user that's closed.
     *
     * @var Authenticatable $user
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @param  Authenticatable  $user
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }
}
