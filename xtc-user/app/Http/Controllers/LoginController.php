<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\SessionController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public static function verify(Request $request){
        $user = User::where('username', $request->input('username'))->first();
        if ($user == null){
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid username or password'
            ]);
        }

        if (!Hash::check($request->input('password'), $user->password)){
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid username or password'
            ]);
        }

        if ($user->is_banned == 1){
            return response()->json([
                'status' => 'error',
                'message' => 'Your account has been banned'
            ]);
        }

        $token = SessionController::startSession($user->uid);

        return response()->json([
            'status' => 'success',
            'message' => 'Logged in',
            'token' => $token
        ]);
    }
}
