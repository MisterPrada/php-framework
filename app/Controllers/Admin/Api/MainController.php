<?php

namespace App\Controllers\Admin\Api;

require_once __APP__ . '/Requests/AuthRequest.php';

use App\Requests\AuthRequest;
use Core\Lib\App;
use Core\Lib\Auth;
use Core\Lib\Response;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class MainController extends ApiController
{
    public function index()
    {
        //Auth::basicAuth();

        //var_dump(Auth::$user->token);

        //die;

        return 'admin api controller';
    }

    public function login(AuthRequest $request)
    {
        if (!Auth::login($request->email, $request->password)) {
            return Response::errors(['error' => [
                'email' => 'Email or Password invalid'
            ]]);
        }

        if(!Auth::$user->token){
            Auth::$user->token = createApiToken();
            Auth::$user->save();
        }

        return Response::json([
            'refreshToken' => 'none',
            'accessToken' => Auth::$user->token,
            'userData' => (object)[
                'email' => Auth::$user->email,
                'username' => Auth::$user->name,
                'fullName' => Auth::$user->name,
                'avatar' => null,
                'role' => 'admin',
                "ability" => [
                    [
                        "action" => 'manage',
                        "subject" => 'all',
                    ],
                ],
            ]
        ]);
    }
}