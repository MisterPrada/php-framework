<?php

namespace App\Requests;

require_once __APP__ . '/Validation/Rule.php';

use Core\Lib\Request;
use App\Validation\Rule;

class AuthRequest extends Request
{
    public function rules()
    {
        (new Rule)->fields([
            'email' => 'email|required',
            'name' => 'required',
        ]);
    }
}