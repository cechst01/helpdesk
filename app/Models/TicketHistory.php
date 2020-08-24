<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketHistory extends Model
{
    protected $guarded = [];

    public function ticket(){
        return $this->belongsTo('App\Ticket');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function oldState(){
        return $this->belongsTo('App\TicketState');
    }

    public function newState(){
        return $this->belongsTo('App\TicketState');
    }

    public function getCreatedAtAttribute($value){
        $date = date_create($value);
        return date_format($date,'d. m. Y H:i:s');
    }
}
