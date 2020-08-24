<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Requests\StoreTicket;

class UpdateTicket extends StoreTicket
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {   $rules = parent::rules();
        $newRules = [
            'date_of_completion_client' => '',
            'state_id' => 'required|exists:ticket_states,id',
            'invoiced' => 'required',
        ];

        // pokud je zvolen stav Ke schválení rozpočtu musí být vyplněna nabídka hodin
        if($this->state_id  == 6){
           $newRules['credits_offer'] = 'required|numeric';
           $newRules['date_of_completion_leksys'] = 'required|date_format:d. m. Y|after_or_equal:today';
        }
        if($this->state_id == 8){
           $newRules['credits_real'] = 'required|numeric';
        }
        if($this->type_id == 2){
            $newRules['credits_offer'] = 'max:0';
            $newRules['credits_real'] = 'max:0';
        }
        $merged = array_merge($rules,$newRules);
        return $merged;
    }

    public function messages(){
        $messages = parent::messages();
        $newMessages = [
            'date_of_completion_leksys.required' => 'Pro odeslání požadavku ke schválení rozpočtu je nutné vyplnit odhadované datum dokončení.',
            'date_of_completion_leksys.date_format' => 'Datum není ve správném formátu.',
            'date_of_completion_leksys.after_or_equal' => 'Není možné zadat dřívější datum dokončení než dnešní.',
            'state_id' => 'Stav musí být zadán.',
            'state_id' => 'Zadaná stav neexistuje.',
            'credits_offer.required' => 'Pro odeslání požadavku ke schválení rozpočtu je nutné vyplnit odhadovaný počet hodin.',
            'credits_offer.numeric' => 'Počet hodin musí být číslo.',
            'credits_offer.max' => 'Pokud je typ ticketu reklamace, není možné zadat návrh hodin.',
            'credits_real.required' => 'Pro odeslání požadavku ke kontrole zákazníkem je nutné vyplnit reálný počet hodin.',
            'credits_real.numeric' => 'Počet hodin musí být číslo.',
            'credits_real.max' => 'Pokud je typ ticketu reklamace, není možné zadat skutečný počet hodin.'
        ];
        $merged = array_merge($messages,$newMessages);
        return $merged ;
    }
    
    protected function failedValidation(Validator $validator)
    {
        //dd($validator->errors()->messages());
        $response = redirect()->back()
                    ->with('error','Formulář není správně vyplněn.')
                    ->withInput()
                    ->withErrors($validator->errors());
        
        throw new HttpResponseException($response);
    }
}
