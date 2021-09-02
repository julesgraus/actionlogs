<?php

namespace JulesGraus\Actionlogs;

use Closure;
use Illuminate\Console\OutputStyle;
use JulesGraus\Actionlogs\Services\ActionlogService;
use JulesGraus\Housekeeper\Contracts\CanDoHouseKeeping;

/**
 * Serves as the public api for the package.
 */
class Actionlogs implements CanDoHouseKeeping
{
    public static function listenToAndLog(Closure|string|array $events, Closure $message) {
        (new ActionlogService())->listenToAndLog($events, $message);
    }

    public static function log(string $action, mixed $payload) {
        (new ActionlogService())->log($action, $payload);
    }

    public static function doHousekeeping(OutputStyle $output = null): void
    {
        ActionlogService::doHousekeeping($output);
    }
}
