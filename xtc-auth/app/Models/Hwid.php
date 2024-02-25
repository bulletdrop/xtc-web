<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hwid extends Model
{
    use HasFactory;
    protected $table = 'hwid';
    protected $primaryKey = 'hid';
    protected $fillable = [
        'hid', 'uid', 'core_count', 'disk_serial', 'mainboard_name', 'winuser', 'hwid_hash', 'guid'
    ];
}
