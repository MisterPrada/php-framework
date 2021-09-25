<?php

namespace App\Models;

class User extends Model
{
    public const table = 'users';

    public function role()
    {
        return $this->belongsTo(Role::class, 'id', 'role_id');
    }

}