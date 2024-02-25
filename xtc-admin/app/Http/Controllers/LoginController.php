<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;
use Illuminate\Support\Facades\Redis;

class LoginController extends Controller
{
    public static function login(Request $request) {
        error_log("test");
        $username = $request->input('username');
        $password = $request->input('password');
        $admin = Admin::where('username', $username)->first();
        if ($admin) {
            if (!$admin->active) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Your account has been locked'
                ]);
            };

            if (password_verify($password, $admin->password)) {
                if ($admin->has_to_change_password) {
                    return response()->json([
                        'status' => 'password_change_required',
                        'message' => '/changepassword?username=' . $username
                    ]);
                }

                $token = bin2hex(random_bytes(32));
                $admin->session_token = $token;
                $admin->failed_password_count = 0;
                $admin->save();
                return response()->json([
                    'status' => 'success',
                    'token' => $token
                ]);
            } else {
                $admin->failed_password_count += 1;
                if ($admin->failed_password_count >= 3) {
                    $admin->active = false;
                }
                $admin->save();
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid username or password'
                ]);
            }
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid username or password'
            ]);
        }
    }

    public static function changePassword(Request $request){
        $username = $request->input('username');
        $password = $request->input('password');
        $newPassword = $request->input('newPassword');
        $admin = Admin::where('username', $username)->first();
        if ($admin) {
            if (!password_verify($password, $admin->password))
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid password'
                ]);

            if ($admin->has_to_change_password == false) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Password already changed'
                ]);
            }

            $admin->password = password_hash($newPassword, PASSWORD_BCRYPT, ['cost' => 12]);
            $admin->has_to_change_password = false;
            $admin->save();
            return response()->json([
                'status' => 'success',
                'message' => 'Password changed successfully'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid username'
            ]);
        }
    }

    public static function getCurrentAdmin(Request $request){
        $token = $request->input('token');
        $admin = Admin::where('session_token', $token)->first();
        if ($admin) {
            $admin->password = null;
            return response()->json([
                'status' => 'success',
                'admin' => $admin
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid token'
            ]);
        }
    }
}
