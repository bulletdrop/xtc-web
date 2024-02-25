<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Licenses extends Model
{
    use HasFactory;
    protected $table = 'licenses';
    protected $primaryKey = 'lid';
    protected $fillable = [
        'lid', 'license_key', 'pid', 'uid', 'frozen', 'days_left'
    ];
}
