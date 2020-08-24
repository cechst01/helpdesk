<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketType extends Model
{
    public $timestamps = false;
    
    public function tickets(){
       return $this->hasMany('App\Ticket');
    }
}
