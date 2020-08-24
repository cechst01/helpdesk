<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class UpdateUser extends FormRequest
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
            'phone_number' => 'required',
            'email' => 'required|email|unique:users,email,'. Auth::user()->id,
            'password' => 'sometimes|nullable|min:7',
            'password_confirmation' => 'sometimes|same:password',
        ];
    }
    
    public function messages()
    {
       return[         
            'user_name.required'  => 'Vaše jméno musí být vyplněno.',
            'user_name.max' => 'Maximální délka jména je :max znaků.',
            'phone_number.required' => 'Telefonní číslo musí být vyplněno.',
            'email.required' => 'Email musí být vyplněn.',
            'email.unique' => 'Zadaný email je již použit. Zvolte jiný.',
            'password.min' => 'Minimální délka hesla je: :min znaků.',
            'password_confirmation.same' => 'Zadaná hesla se neshodují.',
       ];
    }
    
     protected function failedValidation(Validator $validator)
    {       
        $response = redirect()->route('update-user',['id' => Auth::user()->id])
                    ->with('error','Formulář není správně vyplněn.')
                    ->withInput()
                    ->withErrors($validator->errors());
        
        throw new HttpResponseException($response);
    }
}
