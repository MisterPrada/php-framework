<?php

namespace App\Models;

use PDO;
use App\Models\User;


class Role extends Model
{
    public const table = 'roles';

    public function users()
    {
        return $this->hasMany(User::class, 'role_id', 'id');
    }
}