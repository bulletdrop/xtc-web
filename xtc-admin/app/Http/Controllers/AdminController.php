<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Hash;
use App\Admin;
use App\Http\Controllers\LogController;

class AdminController extends Controller
{
    public static function viewAll(Request $request){
        $admin = SessionController::checkSession($request);
        if ($admin) {
            $admins = Admin::all();
            return view('pages.admins.all', ['admins' => $admins]);
        } else {
            return redirect('/login');
        }
    }

    public static function view(Request $request){
        $admin = SessionController::checkSession($request);
        if ($admin) {
            $adminD = Admin::where('aid', $request->input('aid'))->first();
            return view('pages.admins.detail', ['admin' => $adminD]);
        } else {
            return redirect('/login');
        }
    }

    public static function storeEdit(Request $request){
        $admin = SessionController::checkSession($request);
        if ($admin && $admin->aid == 1) {
            $adminD = Admin::where('aid', $request->input('aid'))->first();
            $adminD->username = $request->input('username');
            $adminD->email = $request->input('email');

            $adminD->profile_picture_url = $request->input('profile_picture_url');

            if ($request->active == 'on') {
                $adminD->active = 1;
            } else {
                $adminD->active = 0;
            }

            if ($request->has_to_change_password == 'on') {
                $adminD->has_to_change_password = 1;
                $adminD->password = Hash::make($request->input('password'), ['rounds' => 12]);
            } else {
                $adminD->has_to_change_password = 0;
            }

            LogController::writeLog($admin->username . " (" . $admin->aid . ") Edited admin with id: " . $request->input('aid'));

            $adminD->save();

            return redirect('/admins/detail?aid='.$request->aid);
        } else {
            return redirect('/login');
        }
    }

    public static function resetPasswordCount(Request $request){
        $admin = SessionController::checkSession($request);
        if ($admin)
        {
            $adminD = Admin::where('aid', $request->input('aid'))->first();
            $adminD->failed_password_count = 0;
            $adminD->save();

            LogController::writeLog($admin->username . " (" . $admin->aid . ") Reset password count for admin with id: " . $request->input('aid'));

            return redirect('/admins/detail?aid='.$request->aid);
        } else {
            return redirect('/login');
        }
    }
}
