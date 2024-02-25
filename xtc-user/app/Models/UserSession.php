<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSession extends Model
{
    use HasFactory;
    protected $table = 'user_panel_sessions';
    protected $primaryKey = 'id';
    protected $fillable = [
        'uid', 'session_id'
    ];
}
