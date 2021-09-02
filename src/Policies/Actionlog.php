<?php

namespace JulesGraus\Actionlogs\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use JulesGraus\Actionlogs\Contracts\ActionlogPolicy as ActionlogPolicyContract;

class Actionlog implements ActionlogPolicyContract
{
    public function before(User $user = null, string $ability = ''): bool|Response|null
    {
        if($user && $user->role === 1) {
            return true;
        }
        return null; //Fallback to the ability method
    }

    public function index(User $user = null) {
        return true;
    }
}
