<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Failed_HWID extends Model
{
    protected $table = 'failed_hwid';
    protected $primaryKey = 'fhid';
    protected $fillable = [
        'uid', 'core_count', 'disk_serial', 'mainboard_name', 'winuser', 'hwid_hash', 'guid'
    ];
}
