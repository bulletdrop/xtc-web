<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\LicenseController;
use App\Products;
use App\Licenses;
use App\User;
use App\Log;
use App\HWID;
use App\Failed_HWID;
use App\BanLog;
use App\Http\Controllers\StatsController;

class DashboardController extends Controller
{
    public static function index(Request $request) {
        $admin = SessionController::checkSession($request);
        if ($admin) {
            $stats = StatsController::getLast10Stats();
            $lastStats = StatsController::getCurrentStats();
            return view('dashboard', ['admin' => $admin, 'stats' => $stats, 'currentStats' => $lastStats]);
        } else {
            return redirect('/login');
        }
    }

    public static function products(Request $request){
        $admin = SessionController::checkSession($request);
        if ($admin) {
            return view('products', ['admin' => $admin, 'products' => Products::all()]);
        } else {
            return redirect('/login');
        }
    }

    public static function licenses(Request $request){
        $admin = SessionController::checkSession($request);
        if ($admin) {
            $licenses = LicenseController::getAllLicenses();

            return view('pages.licenses.all', ['admin' => $admin, 'licenses' => $licenses]);
        } else {
            return redirect('/login');
        }
    }

    public static function users(Request $request){
        $admin = SessionController::checkSession($request);
        if ($admin) {
            return view('pages.users.all', ['users' => User::all()]);
        } else {
            return redirect('/login');
        }
    }

    public static function userDetail(Request $request){
        $admin = SessionController::checkSession($request);
        if ($admin) {
            $licenses = Licenses::where('uid', $request->uid)->get();

            foreach ($licenses as $license) {
                $license->product = Products::where('pid', $license->pid)->first();
            }


            $data = [
                'user' => User::where('uid', $request->uid)->first(),
                'licenses' => $licenses,
                'hwid' => HWID::where('uid', $request->uid)->first(),
                'failed_hwids' => Failed_HWID::where('uid', $request->uid)->get(),
                'bans' => BanLog::where('uid', $request->uid)->get()
            ];

            error_log($data["user"]->bsod);

            return view('pages.users.detail', $data);
        } else {
            return redirect('/login');
        }
    }

    public static function viewLogs(Request $request){
        $admin = SessionController::checkSession($request);
        if ($admin) {
            return view('logs', ['admin' => $admin, 'logs' => Log::all()]);
        } else {
            return redirect('/login');
        }
    }
}
