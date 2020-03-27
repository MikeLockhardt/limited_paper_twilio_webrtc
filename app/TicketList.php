<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketList extends Model
{
    protected $fillable = ['user_id', 'type', 'content', 'request_type', 'parent_ticket_id', 'side', 'read_mark', 'user_ticket_id'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}