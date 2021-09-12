<?php

namespace App\Models;

use PDO;

class User extends Model
{
    protected $table = 'users';

/*    public function roles()
    {
        $query = "
            SELECT * FROM {$this->table} 
            LEFT JOIN roles ON users.`role_id` = roles.`id` 
            ";

        return self::$connection->query($query)->fetch;
    }*/


}