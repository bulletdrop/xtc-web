<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Log;
use App\Http\Controllers\SessionController;

class LogController extends Controller
{
    public static function writeLog($message, $console = false){
        if ($console == true)
            error_log($message);

        $log = Log::create([
            'message' => $message
        ]);

        return $log->id;
    }
}
