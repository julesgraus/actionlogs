<?php

namespace JulesGraus\Actionlogs\Tests\Artifacts;

use Illuminate\Foundation\Auth\User;

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
