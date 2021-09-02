<?php

namespace JulesGraus\Actionlogs\Contracts;

use App\Models\User;
use Illuminate\Auth\Access\Response;

interface ActionlogPolicy
{
    public function before(User $user, string $ability): bool|Response|null;
}
