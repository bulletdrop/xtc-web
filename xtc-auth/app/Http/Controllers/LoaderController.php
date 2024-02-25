<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use storage
use Illuminate\Support\Facades\Storage;
use App\Models\Hwid;
use App\Models\Products;
use App\Models\User;
use App\Models\Licenses;
use App\Http\Controllers\VersionController;
class LoaderController extends Controller
{
    public static function getCSGO2DLL(Request $request){
        $file = Storage::disk('local')->get('xtc-cs2-usermode.dll');
        //echo base64($file, 'aes-128-ECB', 'xtc-cs2-usermode', OPENSSL_RAW_DATA);

        return $file;
    }

    public static function getDLL(Request $request){
        $content = json_decode($request->getContent());
        if (!VersionController::checkVersion($content->ver)){
            return response()->json([
                'status' => 418,
                'message' => 'Unauthorized'
            ]);
        }

        $hwid_hash = $content->hwid->hwid_hash;

        $hwid = Hwid::where('hwid_hash', $hwid_hash)->first();
        if ($hwid == null){
            return response()->json([
                'status' => 402,
                'message' => 'No license'
            ]);
        }

        $uid = $hwid->uid;
        $user = User::where('uid', $uid)->first();

        if ($user == null){
            return response()->json([
                'status' => 404,
                'message' => 'User not found'
            ]);
        }

        if ($user->is_banned){
            return response()->json([
                'status' => 403,
                'message' => 'User is banned'
            ]);
        }

        $productName = $content->product_name;

        $product = Products::where('product_name', $productName)->first();
        if ($product == null){
            return response()->json([
                'status' => 404,
                'message' => 'Product not found'
            ]);
        }

        $license = Licenses::where('uid', $uid)->where('pid', $product->pid)->first();
        if ($license == null){
            return response()->json([
                'status' => 402,
                'message' => 'No license'
            ]);
        }

        if ($license->days_left <= 0){
            return response()->json([
                'status' => 402,
                'message' => 'No license'
            ]);
        }

        if ($license->frozen){
            return response()->json([
                'status' => 402,
                'message' => 'No license'
            ]);
        }

        $file = Storage::disk('local')->get($product->file_name);
        //openssl_encrypt($file, 'aes-128-ECB', '8MD564md8MD564md', OPENSSL_RAW_DATA);
        $key = env("DLL_ENCRYPTION_PREFIX_KEY") . substr($hwid_hash, 4, 12);
        return openssl_encrypt($file, 'aes-128-ECB', $key, OPENSSL_RAW_DATA);
    }
}
