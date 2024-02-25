<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HWID extends Model
{
    protected $table = 'hwid';
    protected $primaryKey = 'hid';
    protected $fillable = [
        'uid', 'core_count', 'disk_serial', 'mainboard_name', 'winuser', 'hwid_hash', 'guid'
    ];
}
