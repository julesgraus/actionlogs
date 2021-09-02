<?php

namespace JulesGraus\Actionlogs\Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\Action;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Hash;
use JulesGraus\Actionlogs\Actionlogs;
use JulesGraus\Actionlogs\Models\Actionlog;
use JulesGraus\Actionlogs\Services\ActionlogService;
use JulesGraus\Actionlogs\Contracts\Actionlog as ActionlogContract;
use JulesGraus\Actionlogs\Tests\Artifacts\SampleEvent;
use JulesGraus\Actionlogs\Tests\Artifacts\SampleUser;
use JulesGraus\Actionlogs\Tests\TestCase;

class ActionlogTest extends TestCase
{
    use RefreshDatabase;

    private ActionlogContract $actionlogClass;

    public function setUp(): void
    {
        parent::setUp();
        $this->actionlogClass = app(ActionlogContract::class);
    }

    public function testLogging() {
        $user = SampleUser::query()->create([
            'first_name' => 'Jules',
            'last_name' => 'Graus-Niessen',
            'email' => 'jules.graus@gmail.com',
            'password' => Hash::make('test123')
        ]);


        $this->assertDatabaseCount($this->actionlogClass, 0);

        //Create a test action, linked to the authenticated user. and Assert that.
        auth()->login($user);
        Actionlogs::log('test action', ['some' => 'data']);

        $actionLogs = Actionlog::query()->get();
        $this->assertCount(1, $actionLogs);
        /** @var Actionlog $actionLog */
        $actionLog = $actionLogs->first();
        $this->assertEquals('test action', $actionLog->action);
        $this->assertEquals(['some' => 'data'], $actionLog->payload);

        //Create a second test action, linked to a "guest". And assert that.
        auth()->logout();
        Actionlogs::log('test action 2', 'did something');

        $actionLogs = Actionlog::query()->get();
        $this->assertCount(2, $actionLogs);
        /** @var Actionlog $actionLog */
        $actionLog = $actionLogs->last();

        $this->assertEquals('test action 2', $actionLog->action);
        $this->assertEquals('did something', $actionLog->payload);
        $this->assertEquals(null, $actionLog->user);
    }

    public function testRegisteringEventAndLogging() {
        $email = 'a@sample.user';

        Actionlogs::listenToAndLog(SampleEvent::class, fn(SampleEvent $event) => $event->user->email.' tests actionlogging');
        SampleEvent::dispatch(new User(['email' => $email]));

        $actionLogs = Actionlog::query()->get();
        $this->assertCount(1, $actionLogs);
        /** @var Actionlog $actionLog */
        $actionLog = $actionLogs->last();

        $this->assertEquals('a@sample.user tests actionlogging', $actionLog->action);
        $this->assertEquals(null, $actionLog->user);
    }
}
