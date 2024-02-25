<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BanLog extends Model
{
    use HasFactory;
    protected $table = 'ban_logs';
    protected $primaryKey = 'blid';
    protected $fillable = [
        'uid', 'reason'
    ];
}
