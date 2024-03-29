<?php

namespace App\Http\Controllers;

use App\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function detail($user)
    {
        $user = User::find($user);
        if ($user) {
            return response()->json([
                'message' => 'Success show detail',
                'success' => true,
                'data' => $user
            ], 200);
        } else {
            return response()->json([
                'message' => 'User Tidak ditemukan',
                'success' => false,
                'data' => $user,
            ], 400);
        }
    }
}
