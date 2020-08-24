<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketComment extends Model
{
    public $guarded = [];
    
    public function user(){
      return  $this->belongsTo('App\User');
    }
    
    public function ticket(){
        return $this->belongsTo('App\Ticket');
    }

    public function getCreatedAtAttribute($value){
        $date = date_create($value);
        return date_format($date,'d. m. Y H:i:s');
    }
}
