<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Settings;

class VersionController extends Controller
{
    public static function checkVersion($ver)
    {
        $version = Settings::where('name', 'version')->first();
        if ($version == null){
            return false;
        }

        if ($version->intval == $ver){
            return true;
        }

        return false;
    }
}
