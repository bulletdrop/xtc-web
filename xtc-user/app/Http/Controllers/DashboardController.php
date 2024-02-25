<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\LicenseController;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Products;
use Illuminate\Contracts\Session\Session;

class DashboardController extends Controller
{
    public static function viewHome(Request $request){
        $uid = SessionController::validSession($request->cookie('session_token'));
        if ($uid == false){
            return redirect('/auth/login');
        }

        $user = User::where('uid', $uid)->first();
        $licenses = LicenseController::fetch($uid);
        $licenseCount = count($licenses);

        $openTicketCount = Ticket::where('uid', $uid)->where('is_closed', 0)->count();

        foreach ($licenses as $license){
            $license->pid = Products::where('pid', $license->pid)->first()->product_name;
        }


        return view('pages.panel.home', [
            'username' => $user->username,
            'profile_picture_url' => $user->profile_picture_url,
            'licenses' => $licenses,
            'licenseCount' => $licenseCount,
            'openTicketCount' => $openTicketCount
        ]);
    }

    public static function viewCreateTicket(Request $request){
        $uid = SessionController::validSession($request->cookie('session_token'));
        if ($uid == false){
            return redirect('/auth/login');
        }

        $user = User::where('uid', $uid)->first();

        return view('pages.panel.create-ticket', [
            'username' => $user->username,
            'profile_picture_url' => $user->profile_picture_url
        ]);
    }
}
