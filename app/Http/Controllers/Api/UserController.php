<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JWTAuth;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.verify', ['except' => ['login']]);
    }
    public function login( Request $request) {
    	$credentials = $request->only('email', 'password');
        if (!($token = auth('api')->attempt($credentials))) {
            return response()->json([
                'status' => 'error',
                'error' => 'invalid.credentials',
                'msg' => 'Invalid Credentials.'
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json(['token' => $token], Response::HTTP_OK);
        // return response()->json([
        //     'access_token' => $token,
        //     'token_type' => 'bearer',
        //     'expires_in' => auth('api')->factory()->getTTL() * 60
        // ]);
    }
    public function logout(Request $request) {
        auth('api')->logout($request->token);
        return response()->json(['message' => 'Successfully logged out']);
    }
}
