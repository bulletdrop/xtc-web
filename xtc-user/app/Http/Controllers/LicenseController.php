<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Licenses;
use App\Http\Controllers\SessionController;
use App\Models\Products;

class LicenseController extends Controller
{
    public static function fetch($uid){
        $licenses = Licenses::where('uid', $uid)
        ->where('days_left', '>', 0)->get();
        return $licenses;
    }

    public static function fetchJson(Request $request){
        $token = $request->cookie('session_token');
        $uid = SessionController::validSession($token);
        if (!$uid){
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid session'
            ]);
        }

        $licenses = Licenses::where('uid', $uid)
        ->where('days_left', '>', 0)->get();

        $licensesJson = [];
        foreach ($licenses as $license){
            $licenseJson = [
                'lid' => $license->lid,
                'pid' => $license->pid,
                'product_name' => Products::where('pid', $license->pid)->first()->product_name,
                'days_left' => $license->days_left,
                'freezed' => $license->freezed
            ];
            array_push($licensesJson, $licenseJson);
        }

        return response()->json([
            'status' => 'success',
            'licenses' => $licensesJson
        ]);
    }

    public static function mergeLicense($lid, $days){
        $license = Licenses::where('lid', $lid)->first();
        $license->days_left += $days;
        $license->save();
    }

    public static function checkIfUserHasProduct($uid, $pid){
        $license = Licenses::where('uid', $uid)->where('pid', $pid)->first();
        if ($license == null){
            return false;
        }
        return $license->lid;
    }



    public static function redeem(Request $request){
        $key = $request->input('key');
        $license = Licenses::where('license_key', $key)->first();

        if ($license == null){
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid license key'
            ]);
        }

        if ($license->uid != 0){
            return response()->json([
                'status' => 'error',
                'message' => 'License already redeemed'
            ]);
        }

        if ($license->days_left == 0){
            return response()->json([
                'status' => 'error',
                'message' => 'License expired'
            ]);
        };

        $uid = SessionController::validSession($request->cookie('session_token'));

        if (!$uid){
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid session'
            ]);
        }

        $userHasProduct = self::checkIfUserHasProduct($uid, $license->pid);
        if ($userHasProduct != false){
            self::mergeLicense($userHasProduct, $license->days_left);
            $license->delete();
        }
        else{
            $license->uid = $uid;
            $license->save();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'License redeemed',
            'product_name' => Products::where('pid', $license->pid)->first()->product_name,
            'days_left' => $license->days_left,
            'freezed' => $license->freezed
        ]);
    }
}
