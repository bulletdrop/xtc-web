<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Stats;
use App\User;
use App\Licenses;
use App\Admin;

class StatsController extends Controller
{
    public static function saveStats(Request $request){
        $apikey = $request->input('apikey');
        if ($apikey != env("API_KEY"))
            return "error";

        $stats = Stats::create([
            'users' => User::count(),
            'admins' => Admin::count(),
            'licenses' => Licenses::count()
        ]);
        return $stats;
    }

    public static function getLast10Stats(){
        $stats = Stats::orderBy('created_at', 'desc')->take(10)->get();
        return $stats;
    }

    public static function getCurrentStats(){
        $stats = Stats::orderBy('created_at', 'desc')->first();
        return $stats;
    }
}
