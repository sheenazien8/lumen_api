<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $password = app('hash')->make($request->password);
        $register = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $password
        ]);

        if ($register) {
            return response()->json([
                'message' => 'Register Success',
                'success' => true,
                'data' => $register
            ], 200);
        } else {
            return response()->json([
                'message' => 'Register is fail',
                'success' => false,
                'data' => ''
            ], 400);
        }
    }

    public function login(Request $request)
    {
        $user  = User::whereEmail($request->email)->first();
        if (!$user) {
            return response()->json([
                'message' => 'Email Belum Terdaftar',
                'success' => false,
                'data' => [
                    'user' => '',
                    'api_token' => ''
                ]
            ]);
        }
        if (app('hash')->check($request->password, $user->password)) {
            $apiToken = base64_encode(str_random(40));
            $user->update([
                'api_token' => $apiToken
            ]);

            return response()->json([
                'message' => 'Login Success!!',
                'success' => true,
                'data' => [
                    'user' => $user,
                    'api_token' => $apiToken
                ]
            ]);
        } else {
            return response()->json([
                'message' => 'Login is Fail!!',
                'success' => false,
                'data' => [
                    'user' => '',
                    'api_token' => ''
                ]
            ]);
        }
    }
}
