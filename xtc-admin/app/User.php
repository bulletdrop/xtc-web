<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    protected $table = 'users';
    protected $primaryKey = 'uid';
    protected $fillable = [
        'uid', 'username', 'email', 'password', 'bsod', 'profile_picture_url'
    ];
}
