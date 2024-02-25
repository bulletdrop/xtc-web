<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;

class SessionController extends Controller
{
    private static function getAdmin($token) {
        return Admin::where('session_token', $token)->first();
    }

    public static function checkSession(Request $request) {
        $token = $request->cookie('session_token');
        $admin = self::getAdmin($token);
        if ($admin == null) {
            return false;
            if (!$admin->active)
                return false;
        }

        if ($admin->has_to_change_password)
            return false;

        return $admin;
    }
}
