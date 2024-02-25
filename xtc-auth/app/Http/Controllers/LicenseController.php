<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Licenses;
use App\Models\User;
use App\Models\Products;

class LicenseController extends Controller
{
    public static function userHasLicense(User $user){
        $license = Licenses::where('uid', $user->uid)->first();
        if ($license == null){
            return false;
        }
        return true;
    }

    public static function getLicense(User $user){
        $license = Licenses::where('uid', $user->uid)->get();

        $hidden = ["lid", "uid", "created_at", "updated_at"];
        foreach ($license as $l){
            foreach ($hidden as $hide){
                unset($l->$hide);
            }

            $product = Products::where('pid', $l->pid)->first();
            $l->product_name = $product->product_name;
            unset($l->pid);
        }
        if ($license == null){
            return false;
        }
        return $license;
    }
}
