<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketAttachment extends Model
{
    protected $fillable = ['ticket_id','url','name'];
    public function ticket(){
       return $this->belongsTo('App\Ticket');
    }
}
