<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    protected $table = 'users';
    protected $primaryKey = 'uid';
    protected $fillable = [
        'uid', 'username', 'email', 'password', 'is_banned', 'bsod'
    ];
}
