<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserSession;
use App\Models\User;

class SessionController extends Controller
{
    public static function startSession($uid){
        $session = new UserSession;
        $session->uid = $uid;
        $session->session_id = bin2hex(random_bytes(32));
        $session->save();
        return $session->session_id;
    }

    public static function validSession($token){
        $session = UserSession::where('session_id', $token)->first();
        if ($session == null){
            return false;
        }

        $user = User::where('uid', $session->uid)->where('is_banned', 0)->first();
        if ($user == null){
            return false;
        }

        return $user->uid;
    }

    public static function logout(Request $request){
        $session = UserSession::where('session_id', $request->cookie('session_token'))->first();
        if ($session != null)
            $session->delete();
    }

    public static function verify(Request $request){
        $session = UserSession::where('session_id', $request->input('token'))->first();
        if ($session == null){
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid session'
            ]);
        }

        $user = User::where('uid', $session->uid)->first();
        if ($user == null){
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid session'
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Valid session',
            'username' => $user->username,
            'uid' => $user->uid
        ]);
    }
}
