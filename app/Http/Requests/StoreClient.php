<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class StoreClient extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
         return [
            'user_name' => 'required|max:190',
            'company_name' => 'required|max:190',
            'phone_number' => 'required',
            'email' => 'required|email|unique:users,email,',
            'password' => 'required|min:7',
            'password_confirmation' => 'same:password',
            'count.*' => 'required|numeric',
            'valid_from.*' => 'date_format:d. m. Y|after_or_equal:today',
            'valid_to.*' => 'date_format:d. m. Y|after_or_equal:today'
        ];
    }
    
    public function messages()
    {
       return[         
            'user_name.required'  => 'Jméno klienta musí být vyplněno.',
            'user_name.max' => 'Maximální délka jména je :max znaků.',
            'company_name.required'  => 'Název firmy musí být vyplněn.',
            'company_name.max' => 'Maximální délka názvu je :max znaků.',
            'phone_number.required' => 'Telefonní číslo musí být vyplněno.',
            'email.required' => 'Email musí být vyplněn.',
            'email.unique' => 'Zadaný email je již použit. Zvolte jiný.',
            'password.required' => 'Heslo musí být vyplněno.',
            'password.min' => 'Minimální délka hesla je: :min znaků.',
            'password_confirmation.same' => 'Zadaná hesla se neshodují.',
            'count.*.required' => 'Musíte vyplnit počet kreditů.',
            'count.*.number' => 'Zadaná hodnota musí být číslo.',
            'valid_from.*.date_format' => 'Datum platnosti od není ve správném formátu.',
            'valid_from.*.after_or_equal' => 'Kredity je možné přiřadit nejdříve ode dneška.',
            'valid_to.*.date_format' => 'Datum platnosti do není ve správném formátu.',
            'valid_to.*.after_or_equal' => 'Kredity musí mít platnost alespoň dnes.'
       ];
    }
    
    protected function failedValidation(Validator $validator)
    {       
        $response = redirect()->route('create-client')
                    ->with('error','Formulář není správně vyplněn.')
                    ->withInput()
                    ->withErrors($validator->errors());
        
        throw new HttpResponseException($response);
    }
}
