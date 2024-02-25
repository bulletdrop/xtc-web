<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;
    protected $table = 'admins';
    protected $primaryKey = 'aid';
    protected $fillable = [
        'aid', 'username', 'password', 'email', 'session_token', 'active', 'failed_password_count'
    ];

}
