<?php


namespace JulesGraus\Actionlogs\Services;


use Closure;
use Illuminate\Console\OutputStyle;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use JulesGraus\Actionlogs\Contracts\Actionlog as ActionlogContract;
use JulesGraus\Housekeeper\Contracts\CanDoHouseKeeping;
use function app;
use function auth;
use function config;

class ActionlogService implements CanDoHouseKeeping
{
    public function log(string $action, $payload = null): ActionlogContract
    {
        /** @var Builder $actionlogClass */
        $actionlogClass = app(ActionlogContract::class);

        $actionLog = (new $actionlogClass([
            'action' => $action,
            'payload' => $payload
        ]));

        if(auth()->check()) $actionLog->user()->associate(auth()->user());

        $actionLog->save();
        return $actionLog;
    }

    public static function doHousekeeping(OutputStyle $output = null): void
    {
        /** @var Builder $actionlogClass */
        $actionlogClass = app(ActionlogContract::class);

        $idsToDelete = $actionlogClass::oldest()->skip(config('actionlogs.max_log_entries'))->pluck('id');
        $count = $idsToDelete->count();
        if($count > 0) {
            $actionlogClass::destroy($idsToDelete);
            $output?->writeln('Deleting '.$count.'  old actionlogs');
        } else {
            $output?->writeln('No old actionlogs to delete');
        }

    }

    public function listenToAndLog(array|Closure|string $events, Closure $messageClosure)
    {
        /** @var DispatcherContract $eventdispatcher */
        $eventdispatcher = app(DispatcherContract::class);
        $eventdispatcher->listen($events, function($event) use($messageClosure) {
            $this->log($messageClosure($event));
        });
    }
}
