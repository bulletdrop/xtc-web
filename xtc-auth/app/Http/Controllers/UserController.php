<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Hwid;
use App\Models\BanLog;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\JsonResponse;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\LicenseController;
use App\Http\Controllers\HwidController;
use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\VersionController;

class UserController extends Controller
{
    private static function loginRules(){
        return [
            'username' => 'string|required|max:255|min:2',
            'password' => 'string|required|max:255|min:3',
            'hwid' => 'string|required|min:2'
        ];
    }
    /*
    public static function createUser($request) {
        $user = new User;
        $user->username = $request->input('username');
        $user->email = $request->input('username');
        $password = Hash::make($request->input('password'), [
            'rounds' => 12,
        ]);

        $user->password = $password;
        $user->save();

        return json_encode(['success'=>'User created']);
    }
    */

    /*
        Status codes:
        200 - OK
        402 - No license
        401 - Unauthorized
        403 - Forbidden
        404 - Not found
    */
    private static function verify($credentials, $hwid){
        $data = array(
            'status' => 404,
            'user' => null
        );

        if (strlen($credentials["username"]) > 255 || strlen($credentials["username"]) < 2)
            $data["status"] = 400;

        if (strlen($credentials["password"]) > 255 || strlen($credentials["password"]) < 3)
            $data["status"] = 400;

        if ($data["status"] == 400)
            return $data;

        $user = User::where('username', $credentials["username"])->first();
        if ($user == null){
            $data["status"] = 404;
        }

        if ($user){
            if (Hash::check($credentials["password"], $user->password)) {
                if ($user->is_banned)
                    $data["status"] = 403;

                if ($user->bsod){
                    $data["status"] = 300;
                    return $data;
                }


                if (!LicenseController::userHasLicense($user))
                {
                    $data["status"] = 402;
                    return $data;
                }



                if (!HwidController::userHasHWID($user->uid))
                    HwidController::saveHWID($user->uid, $hwid);
                else if (!HwidController::checkHwid($user->uid, $hwid->hwid_hash)){
                    HwidController::saveFailedHWID($user->uid, $hwid);
                    $data["status"] = 451;
                }
                else
                {
                    $data["status"] = 200;
                    $data["user"] = $user;
                }

                return $data;
            }
            else
                $data["status"] = 401;
        }

        return $data;
    }

    private static function verifyHWID($hwid){
        $data = array(
            'status' => 404,
            'user' => null
        );

        $uid = Hwid::where('hwid_hash', $hwid->hwid_hash)->first();

        if ($uid == null){
            $data["status"] = 404;
            return response()->json(['data' => $data], $data["status"]);
        }

        $uid = $uid->uid;

        $user = User::where('uid', $uid)->first();


        if ($user){
            if ($user->is_banned)
            {
                $data["status"] = 403;
                return response()->json(['data' => $data], $data["status"]);
            }

            if ($user->bsod){
                $data["status"] = 300;
                return response()->json(['data' => $data], $data["status"]);
            }

            if (!LicenseController::userHasLicense($user))
            {
                $data["status"] = 402;
                return response()->json(['data' => $data], $data["status"]);
            }


            if (!HwidController::userHasHWID($user->uid))
                HwidController::saveHWID($user->uid, $hwid);
            else if (!HwidController::checkHwid($user->uid, $hwid->hwid_hash)){
                HwidController::saveFailedHWID($user->uid, $hwid);
                $data["status"] = 451;
            }
            else
            {
                $data["status"] = 200;
                return self::loggedIn($user);
            }

            return response()->json(['data' => $data], $data["status"]);
            }
            else
                $data["status"] = 401;

        return response()->json(['data' => $data], $data["status"]);
    }

    private static function loggedIn(User $user){
        return response()->json([
            'uid' => $user->uid,
            'username' => $user->username,
            'email' => $user->email,
            'licenses' => LicenseController::getLicense($user)
        ], 200);
    }

    public static function loginHWID(Request $request){
        $content = json_decode($request->getContent());
        if (VersionController::checkVersion($content->ver)){
            return self::verifyHWID($content->hwid);
        }
        else
            return response()->json(['error'=>'Unauthorized'], 418);
    }

    public static function login(Request $request){
        LogController::writeLog("Login request", true);
        $content = json_decode($request->getContent());

        if (!VersionController::checkVersion($content->ver)){
            return response()->json(['error'=>'Unauthorized'], 418);
        }

        $credentials = [
            'username' => $content->username,
            'password' => $content->password
        ];

        $hwid = $content->hwid;

        $status = self::verify($credentials, $hwid);
        $statusCode = intval($status["status"]);
        switch($statusCode){
            case 404:
                return response()->json(['error'=>'User not found'], $statusCode);
            case 403:
                return response()->json(['error'=>'User is banned'], $statusCode);
            case 401:
                return response()->json(['error'=>'Wrong username / password'], $statusCode);
            case 400:
                return response()->json(['error' => "Invalid input (username / password too long/short)"], $statusCode);
            case 451:
                return response()->json(['error'=>'Wrong HWID'], $statusCode);
            case 402:
                return response()->json(['error'=>'User has no license'], $statusCode);
            case 300:
                return response()->json(['error'=>'BSOD'], $statusCode);
            case 200:
                return self::loggedIn($status["user"]);
        }

        return response()->json(['error'=>'Unknown error'], 500);
    }

    public static function BanByHWID(Request $request){
        $content = json_decode(openssl_decrypt($request->getContent(), 'aes-128-ECB', env("BAN_MESSAGE_ENCRYPTION_KEY"), OPENSSL_RAW_DATA));

        $hwid = $content->hwid;



        $uid = Hwid::where('hwid_hash', $hwid)->first();

        if ($uid == null){
            return response()->json(['error'=>'User not found'], 404);
        }

        $uid = $uid->uid;

        $user = User::where('uid', $uid)->first();

        if ($user == null){
            return response()->json(['error'=>'User not found'], 404);
        }

        if ($user->is_banned){
            return response()->json(['error'=>'User is already banned'], 403);
        }

        $user->is_banned = true;
        $user->save();

        $banLog = new BanLog;
        $banLog->uid = $uid;
        $banLog->reason = $content->meme;
        $banLog->save();

        return response()->json(['success'=>'User banned'], 200);
    }
}
