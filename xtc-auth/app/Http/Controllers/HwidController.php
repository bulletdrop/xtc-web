<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hwid;
use App\Models\FailedHwid;
use App\Models\User;

class HwidController extends Controller
{
    public static function userHasHWID($uid){
        $hwid = Hwid::where('uid', $uid)->first();
        if ($hwid == null){
            return false;
        }
        return true;
    }

    public static function saveHWID($uid, $hwid){
        $nHwid = new Hwid;
        $nHwid->uid = $uid;
        $nHwid->core_count = $hwid->core_count;
        $nHwid->disk_serial = $hwid->disk_serial;
        $nHwid->mainboard_name = $hwid->mainboard_name;
        $nHwid->winuser = $hwid->winuser;
        $nHwid->hwid_hash = $hwid->hwid_hash;
        $nHwid->guid = $hwid->guid;
        $nHwid->save();
    }

    public static function saveFailedHWID($uid, $hwid){
        $fHwid = new FailedHwid;
        $fHwid->uid = $uid;
        $fHwid->core_count = $hwid->core_count;
        $fHwid->disk_serial = $hwid->disk_serial;
        $fHwid->mainboard_name = $hwid->mainboard_name;
        $fHwid->winuser = $hwid->winuser;
        $fHwid->hwid_hash = $hwid->hwid_hash;
        $fHwid->guid = $hwid->guid;
        $fHwid->save();
    }

    public static function checkHwid($uid, $hwid_hash){
        $hwid = Hwid::where('uid', $uid)->first();
        if ($hwid == null){
            return false;
        }
        if ($hwid->hwid_hash != $hwid_hash){
            return false;
        }
        return true;
    }

}
