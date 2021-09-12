<?php

namespace App\Controllers\Api;

require_once __APP__ . 'Requests/UserRequest.php';
use App\Requests\UserRequest;


class UserController extends ApiController
{
    public function index(UserRequest $request)
    {

        var_dump($request->all());

        die();


        return Response::json(['id' => 'prada']);
    }
}