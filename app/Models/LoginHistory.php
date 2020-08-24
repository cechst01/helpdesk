<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoginHistory extends Model
{
    public function user(){
        return $this->belongsTo('App\User');
    }

    public function getCreatedAtAttribute($value){
        $date = date_create($value);
        return date_format($date,'d. m. Y  H:i:s');
    }

    public function isSuccess(){
        $success = $this->attributes['success'];
        return $success ? 'Ano' : 'Ne';
    }
}
