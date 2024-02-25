<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stats extends Model
{
    use HasFactory;
    protected $table = 'stats';
    protected $primaryKey = 'id';
    protected $fillable = [
        'users', 'admins', 'licenses'
    ];
}
