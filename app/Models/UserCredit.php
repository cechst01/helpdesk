<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCredit extends Model
{
    protected $fillable = ['user_id','count','removed_count','valid_from','valid_to'];
    
    public function user(){
        
        return $this->belongsTo('App\User');
    }
    
    public function getCountAttribute($value){
        return  $value /60;
    }    
        
    public function setCountAttribute($value){
        $this->attributes['count'] = $value * 60;
    }

    public function getRemovedCountAttribute(){

        $value = $this->attributes['removed_count'] / 60;
        return  $value;
    }

    public function setRemovedCountAttribute($value){
        $this->attributes['removed_count'] = $value * 60;
    }


    public function getCreditsInHoursAttribute(){
        $credits = $this->count;
        $hours = floor($credits);
        $minutes = (($credits - $hours)* 60);
        if($minutes == 0){
            $minutes = $minutes.'0';
        }
        return ("$hours:$minutes");
    }

    public function getRemovedCreditsInHoursAttribute(){
        $credits = $this->removedCount;
        $hours = floor($credits);
        $minutes = (($credits - $hours)* 60);
        if($minutes == 0){
            $minutes = $minutes.'0';
        }
        return ("$hours:$minutes");
    }

    public function setValidFromAttribute($value){

        $date = date_create_from_format('d. m. Y',$value);

        $this->attributes['valid_from'] = date_format($date,'Y-m-d');
    }

    public function getValidFromAttribute($value){
        $date = date_create($value);
        return date_format($date,'d. m. Y');
    }

    public function setValidToAttribute($value){
        $date = date_create_from_format('d. m. Y',$value);

        $this->attributes['valid_to'] = date_format($date,'Y-m-d');
    }

    public function getValidToAttribute($value){
        $date = date_create($value);
        return date_format($date,'d. m. Y');
    }


}
