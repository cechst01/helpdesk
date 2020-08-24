<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Ticket extends Model
{
    public function user(){
       return $this->belongsTo('App\User');
    }
    
    public function type(){
       return $this->belongsTo('App\TicketType');
    }
    
    public function state(){
       return  $this->belongsTo('App\TicketState');
    }
    
    public function attachments(){
       return $this->hasMany('App\TicketAttachment');
    }
    
    public function comments(){
        return $this->hasMany('App\TicketComment');
    }

    public function history(){
        return $this->hasMany('App\TicketHistory');
    }

    public function getContentWebalize(){
        $content = nl2br($this->attributes['content']);

        return $content;
    }
    
    public function getTicketsWithoutStates(array $exceptStates){
        $tickets = Ticket::whereHas('state',function($query) use($exceptStates){
            $query->whereNotIn('name',$exceptStates);
        });
       return $tickets;
    }

    public function setStateIdAttribute($stateId){
        $this->attributes['state_id'] = $stateId;
        if($stateId == 4){
            $this->attributes['send_to_approve'] = date('Y-m-d');
        }
    }
    public function changeState($state){
        $stateId = TicketState::where('name',$state)->first()->id;
        $this->state_id = $stateId;
        if($state == 'Ke schválení'){
            $this->send_to_approve = date('Y-m-d');
        }
        $this->history()->create(['ticket_id' => $this->id, 'user_id' => Auth::user()->id,
                                'old_state_id' => $this->getOriginal('state_id'),
                                'new_state_id' => $stateId]);
        $this->save();
    }

    public function setDateOfCompletionClientAttribute($value){
        $date = date_create_from_format('d. m. Y',$value);

        $this->attributes['date_of_completion_client'] = date_format($date,'Y-m-d');
    }

    public function getDateOfCompletionClientAttribute($value){

        $date = date_create($value);
        return date_format($date,'d. m. Y');
    }

    public function setDateOfCompletionLeksysAttribute($value){
        if($value){
            $date = date_create_from_format('d. m. Y',$value);
            $this->attributes['date_of_completion_leksys'] = date_format($date,'Y-m-d');
        }
        else{
            $this->attributes['date_of_completion_leksys'] = $value;
        }

    }

    public function getDateOfCompletionLeksysAttribute($value){
        if($value){
            $date = date_create($value);
            return date_format($date,'d. m. Y');
        }else{
            return $value;
        }
    }

    public function getCreatedAtAttribute($value){
        $date = date_create($value);
        return date_format($date,'d. m. Y  H:i:s');
    }

    public function getAttributesChanges(){
        $changes = [];
        $checkAttributes = ['title','content','type_id','state_id','date_of_completion_leksys','credits_offer'];
        $names = [
            ['Název',0], ['Popis',0], ['Typ',0], ['Status',0], ['Předpokládané datum dokončení',1], ['Navrhovaný počet hodin',0] ];
        $verbs = ['byl změněn', 'bylo změněno', 'byla změněna'];

        foreach($checkAttributes as $index => $attribute){
            if($this->attributes[$attribute] != $this->getOriginal($attribute)){
                $verb = $verbs[$names[$index][1]];
                if($attribute == 'type_id'){
                    //$type = TicketType::find($this->getOriginal($attribute))->name;
                    $newType = TicketType::find($this->attributes[$attribute])->name;
                    $changes[] = $names[$index][0] . " {$verb}  na {$newType}." ;
                }
                elseif($attribute == 'state_id'){
                    //$state = TicketState::find($this->getOriginal($attribute))->name;
                    $newState = TicketState::find($this->attributes[$attribute])->name;
                    $changes[] = $names[$index][0] . " {$verb}   na {$newState}." ;
                }
                elseif($attribute == 'content'){
                    $changes[] = $names[$index][0] . " {$verb}.";
                }
                else{
                    $changes[] = $names[$index][0] . " {$verb}  na {$this->attributes[$attribute]}.";
                }

            }
        }

        return $changes;

    }

    public function getChanges(){
        $stateId = $this->attributes['state_id'];
        $message = [];
        $messages = [
            2 => 'Nyní Váš požadavek zpracováváme... prosíme o trpělivost.',
            3 => 'Požadavek byl zamítnut jako reklamace a bude Vám zaslána časová kalkulace pro schválení z Vaší strany.',
            4 => 'Vaší reklamací se nyní zabýváme a vyřešíme ji co nejdříve.',
            5 => 'Váš požadavek nyní analyzujeme a následně Vám zašleme časovou kalkulaci pro schválení z Vaší strany.',
            6 => 'Nyní Vám byla odeslána kalkulace časové náročnosti ke schválení. Prosíme o Vaši rychlou reakci, abychom Váš požadavek mohli vyřídit co nejdříve. Děkujeme.',
            7 => 'Rozpočet byl z Vaší strany zamítnut. UPRAVIT UPRAVIT UPRAVIT',
            8 => 'Potvrzení rozpočtu z Vaší strany bylo přijato a požadavek vyřizujeme.',
            9 => 'Práce na Vašem požadavku byly dokončeny. Proveďte prosím kontrolu.'   ,
            10 => 'Vaše připomínka k vyhotovenému řešení byla uložena, budeme se jí zabývat.',
            11 => 'Váš požadavek byl vyřízen a byl uzavřen.'
        ];

        if(($stateId != $this->getOriginal('state_id') && $stateId != 1 && $stateId != 12 && $stateId != 7) || $stateId == 8 || $stateId == 9 || $stateId == 10){

            $stateName = TicketState::find($stateId)->name;
            $message[] =  "Stav Vašeho požadavku byl změněn na {$stateName}.";
            $message[] = $messages[$stateId];
        }

        return $message;


    }
}
