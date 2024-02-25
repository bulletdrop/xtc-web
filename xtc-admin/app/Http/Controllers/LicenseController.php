<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Products;
use App\Licenses;
use App\Http\Controllers\LogController;
class LicenseController extends Controller
{
    public static function getAllLicenses(){
        $licenses = Licenses::all();
        foreach ($licenses as $license) {
            $license->product = Products::where('pid', $license->pid)->first()->product_name;
            if ($license->uid != 0) {
                $license->user = User::where('uid', $license->uid)->first()->username;
            } else {
                $license->user = 'N/A';
            }

            if ($license->frozen == 1) {
                $license->status = 'Frozen';
            } else {
                $license->status = 'Active';
            }
        }

        return $licenses;
    }

    public static function deleteLicense(Request $request){
        $admin = SessionController::checkSession($request);
        if ($admin) {
            $lid = $request->input('lid');
            $license = Licenses::where('lid', $lid)->first();
            $license->delete();

            LogController::writeLog($admin->username . " (" . $admin->aid . ") Deleted license with id: " . $lid);

            return redirect('/licenses');
        } else {
            return redirect('/login');
        }
    }

    public static function viewDetail(Request $request){
        $admin = SessionController::checkSession($request);
        if ($admin) {
            $lid = $request->input('lid');
            $license = Licenses::where('lid', $lid)->first();
            $license->product = Products::where('pid', $license->pid)->first();
            if ($license->uid != 0) {
                $license->user = User::where('uid', $license->uid)->first();
            } else {
                $license->user = 'N/A';
            }

            if ($license->frozen == 1) {
                $license->status = 'Frozen';
            } else {
                $license->status = 'Active';
            }

            $allUsers = User::all();
            $allProducts = Products::all();
            $data = [
                'admin' => $admin,
                'license' => $license,
                'allUsers' => $allUsers,
                'allProducts' => $allProducts
            ];
            return view('pages.licenses.detail', $data);
        } else {
            return redirect('/login');
        }
    }

    public static function addLicense(Request $request){
        $admin = SessionController::checkSession($request);
        if ($admin) {
            $products = Products::all();
            return view('pages.licenses.add', ['admin' => $admin, 'products' => $products]);
        } else {
            return redirect('/login');
        }
    }



    public static function store(Request $request){
        $admin = SessionController::checkSession($request);
        if ($admin) {
            $separator = $request->input('separator');
            $pid = $request->input('pid');
            $keys = array();
            if ($separator == "x"){
                $keys = explode("\n", $request->input('keys'));
                for ($i = 0; $i < count($keys); $i++){
                    $keys[$i] = rtrim($keys[$i]);
                }
            }
            else
               $keys = explode($separator, $request->input('keys'));

            $count = 0;

            foreach ($keys as $key) {
                $license = Licenses::where('license_key', $key)->first();
                if ($license)
                    continue;

                $license = new Licenses;
                $license->pid = $pid;
                $license->license_key = $key;
                $license->uid = 0;
                $license->days_left = $request->input('days');
                $license->save();
                $count++;
            }

            LogController::writeLog($admin->username . " (" . $admin->aid . ") Added " . $count . " licenses with pid: " . $pid);

            return redirect('/licenses');
        }
    }

    public static function storeEditLicense(Request $request){
        $admin = SessionController::checkSession($request);
        if ($admin) {
            $lid = $request->input('lid');
            $license = Licenses::where('lid', $lid)->first();
            $license->license_key = $request->input('license_key');
            $license->pid = $request->input('pid');
            $license->uid = $request->input('uid');
            $license->days_left = $request->input('days_left');
            if ($request->input('frozen') == 'on')
                $license->frozen = 1;
            else
                $license->frozen = 0;
            $license->save();

            LogController::writeLog($admin->username . " (" . $admin->aid . ") Edited license with id: " . $lid);

            return redirect('/licenses');
        }
        else
            return redirect('/login');
    }

    public static function removeDay(Request $request){
        $apikey = $request->input('apikey');
        if ($apikey != env("API_KEY"))
            return "error";

        $licenses = Licenses::all();
        foreach ($licenses as $license) {
            if ($license->frozen == 1)
                continue;

            if ($license->days_left == 0)
            {
                $license->delete();
                continue;
            }
            $license->days_left = $license->days_left - 1;
            $license->save();
        }
    }
}
