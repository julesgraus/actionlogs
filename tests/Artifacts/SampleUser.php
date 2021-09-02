<?php

namespace JulesGraus\Actionlogs\Tests\Artifacts;

use App\Models\User;

class SampleUser extends User
{
    protected $table = 'users';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
    ];
}
