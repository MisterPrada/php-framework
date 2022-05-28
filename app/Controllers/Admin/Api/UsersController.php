<?php


namespace App\Controllers\Admin\Api;


use Core\Lib\Response;

class UsersController extends ApiController
{
    public function index() {
        return Response::json(['success' => true]);
    }
}