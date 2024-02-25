<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table = 'tickets';
    protected $primaryKey = 'tid';
    protected $fillable = [
        'tid', 'title', 'uid', 'is_closed'
    ];
}
