<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketMessages extends Model
{
    protected $table = 'ticket_messages';
    protected $primaryKey = 'tmid';
    protected $fillable = [
        'tmid', 'tid', 'uid', 'aid', 'message'
    ];
}
