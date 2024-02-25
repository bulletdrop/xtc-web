<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\SessionController;
class CreateAccountController extends Controller
{
    public static function index(){
        return view('create-account');
    }

    public static function store($username, $email, $password){
        $user = new User;
        $user->username = $username;
        $user->email = $email;
        $password = Hash::make($password, [
            'rounds' => 12,
        ]);

        $user->is_banned = false;
        $user->bsod = false;

        $user->password = $password;
        $user->save();

        $token = SessionController::startSession($user->uid);

        return response()->json(['status'=>'success', 'success'=>'User created', 'token' => $token], 200);
    }



    public static function verify(Request $request)
    {
        if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i", $request->input('email'))){
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid e-mail address'
            ]);
        }

        if (strlen($request->input('password')) < 8) {
            return response()->json([
                'status' => 'error',
                'message' => 'Password must be at least 8 characters'
            ]);
        }

        if (!preg_match('/[A-Z]/', $request->input('password'))) {
            return response()->json([
                'status' => 'error',
                'message' => 'Password must contain at least one upper case letter'
            ]);
        }

        if (strlen($request->input('username')) < 4) {
            return response()->json([
                'status' => 'error',
                'message' => 'Username must be at least 4 characters'
            ]);
        }

        if ($request->input('password') != $request->input('confirmPassword')) {
            return response()->json([
                'status' => 'error',
                'message' => 'Passwords do not match'
            ]);
        }

        if (User::where('username', $request->input('username'))->exists()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Username already exists'
            ]);
        }

        if (User::where('email', $request->input('email'))->exists()) {
            return response()->json([
                'status' => 'error',
                'message' => 'E-mail already exists'
            ]);
        }

        return self::store($request->input('username'), $request->input('email'), $request->input('password'));

    }
}
