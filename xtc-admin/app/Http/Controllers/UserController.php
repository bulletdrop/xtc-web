<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Failed_HWID;
use App\HWID;
use App\Http\Controllers\LogController;

class UserController extends Controller
{
    public static function ban(Request $request){
        $admin = SessionController::checkSession($request);
        if ($admin) {
            $user = User::where('uid', $request->uid)->first();
            $user->is_banned = 1;
            $user->save();

            LogController::writeLog($admin->username . " (" . $admin->aid . ") Banned user with id: " . $request->uid);

            return redirect('/users');
        } else {
            return redirect('/login');
        }
    }

    public static function unBan(Request $request){
        $admin = SessionController::checkSession($request);
        if ($admin) {
            $user = User::where('uid', $request->uid)->first();
            $user->is_banned = 0;
            $user->save();

            LogController::writeLog($admin->username . " (" . $admin->aid . ") Unbanned user with id: " . $request->uid);

            return redirect('/users');
        } else {
            return redirect('/login');
        }
    }

    public static function setHWID(Request $request){
        $admin = SessionController::checkSession($request);
        if ($admin) {
            $failedHWID = Failed_HWID::where('fhid', $request->fhid)->first();

            $hwid = HWID::where('uid', $failedHWID->uid)->first();
            $hwid->core_count = $failedHWID->core_count;
            $hwid->disk_serial = $failedHWID->disk_serial;
            $hwid->mainboard_name = $failedHWID->mainboard_name;
            $hwid->winuser = $failedHWID->winuser;
            $hwid->hwid_hash = $failedHWID->hwid_hash;
            $hwid->guid = $failedHWID->guid;
            $hwid->save();

            LogController::writeLog($admin->username . " (" . $admin->aid . ") Set HWID for user with id: " . $failedHWID->uid);

            return redirect('/users');
        } else {
            return redirect('/login');
        }
    }

    public static function editUser(Request $request){
        $admin = SessionController::checkSession($request);
        if ($admin) {
            $user = User::where('uid', $request->uid)->first();
            if ($request->bsod == 'on')
                $user->bsod = 1;
            else
                $user->bsod = 0;

            $user->username = $request->username;
            $user->email = $request->email;
            $user->profile_picture_url = $request->profile_picture_url;
            $user->save();

            LogController::writeLog($admin->username . " (" . $admin->aid . ") Edited user with id: " . $request->uid);

            return redirect('/users');
        } else {
            return redirect('/login');
        }
    }
}
