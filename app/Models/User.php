<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\UserCredit;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    private $slackWebhookUrl = 'https://hooks.slack.com/services/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';

    public function  routeNotificationForSlack($notification){
        return $this->slackWebhookUrl;
    }
    
    public function credits(){      
        return $this->hasMany('App\UserCredit')->orderBy('valid_from','desc');
    }

    public function comments(){
        return $this->hasMany('App\TicketCommet')->orderBy('created_at','asc');
    }
    
    public function tickets(){
        return $this->hasMany('App\Ticket')->orderBy('state_id', 'asc');
    }

    public function getActualCreditsAttribute(){
       $today = date('Y-m-d'); 
       $credits = $this->credits()->where('valid_from','<=',$today)
                             ->where('valid_to','>=',$today)
                             ->first();
       return $credits;
    }
    
    public function setActualCreditsAttribute($number){
       $today = date('Y-m-d'); 
       $credits = $this->credits()->where('valid_from','<=',$today)
                             ->where('valid_to','>=',$today)
                             ->first();
       $credits->count = $number;
       $credits->save();
    }

    public function removeCredit($hours){
        //dostanu v hodinach pro minuty vynasobim
        $actualInMinutes = $this->getActualCreditsAttribute()->count * 60;
        $credits = $actualInMinutes - ($hours * 60);
        $creditsInHours = $credits / 60;
        $this->setActualCreditsAttribute($creditsInHours);
        $this->setRemovedCredit($hours);
    }

    public function setRemovedCredit($number){
        $today = date('Y-m-d');
        $credits = $this->credits()->where('valid_from','<=',$today)
            ->where('valid_to','>=',$today)
            ->first();

        $credits->removedCount =  $credits->removedCount + $number;
        $credits->save();
    }

    public function getLastActivityAttribute($value){
        $date = date_create($value);
        return date_format($date,'d. m. Y H:i:s');
    }
       
}
