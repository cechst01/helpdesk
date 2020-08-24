<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketState extends Model
{
    public $timestamps = false;
    
    public function tickets(){
       return $this->hasMany('App\Ticket');
    }
    
    public function getStatesWithout(array $exceptStates){        
        $states = TicketState::whereNotIn('name',$exceptStates)->get();
        return $states;        
    }
}
