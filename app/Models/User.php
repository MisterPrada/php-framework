<?php

namespace App\Models;

require_once __APP__ . '/Observers/UserObserver.php';

use App\Observers\UserObserver;

class User extends Model
{
    public const table = 'users';

    static $observerClasses = [
        UserObserver::class
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'id', 'role_id');
    }

}