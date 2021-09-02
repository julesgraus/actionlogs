<?php

namespace JulesGraus\Actionlogs\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin Model
 */
interface Actionlog
{
    public function user(): BelongsTo;
}
