<?php

namespace App\Http\Controllers;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Dingo\Api\Routing\Helpers;

class AuthenticateController extends Controller
{
    use Helpers;

    public function authenticate(Request $request)
    {
        try {
            if (! $token = JWTAuth::attempt($request->only('email', 'password'))) {
                return $this->response->error('Invalid credentials', 401);
            }
        } catch (JWTException $e) {
            return $this->response->error('Could not create token', 500);
        }

        // all good so return the token
        return response()->json(compact('token'));
    }

    public function validateToken()
    {
        return $this->response->array(['status' => 'success'])->statusCode(200);
    }
}