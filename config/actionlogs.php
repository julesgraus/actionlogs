<?php
return [
    /*
    |--------------------------------------------------------------------------
    | Prefix
    |--------------------------------------------------------------------------
    |
    | The prefix to apply to the actionlog urls.
    | Defaults to actionlogs
    |
    */
    'prefix' => env('ACTIONLOGS_ROUTE_PREFIX', 'actionlogs'),

    /*
    |--------------------------------------------------------------------------
    | Middleware
    |--------------------------------------------------------------------------
    |
    | The middleware to apply on all actionlog routes. Comma separated.
    | You could for example secure them with api authentication middleware.
    |
    */
    'middleware' => env('ACTIONLOGS_MIDDLEWARE', 'api'),

    /*
    |--------------------------------------------------------------------------
    | Max log entries count
    |--------------------------------------------------------------------------
    |
    | How many log items there may be stored at max
    |
    */
    'max_log_entries' => env('ACTIONLOGS_MAX_LOG_ENTRIES', 500)
];
