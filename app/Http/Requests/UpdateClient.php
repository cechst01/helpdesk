<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class UpdateClient extends StoreClient
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = parent::rules();
        $newRules = [
            'password' => 'sometimes|nullable|min:7',
            'email' => 'required|email|unique:users,email,'. $this->id,
            'valid_from.*' => 'date_format:d. m. Y',
            'valid_to.*' => 'date_format:d. m. Y'
        ];

        $merged = array_merge($rules,$newRules);
        return $merged;
    }

    public function messages(){
        $messages = parent::messages();
        $newMessages = [

        ];
        $merged = array_merge($messages,$newMessages);
        return $messages;
    }

    protected function failedValidation(Validator $validator)
    {
        $response = redirect()->back()
            ->with('error','Formulář není správně vyplněn.')
            ->withInput()
            ->withErrors($validator->errors());

        throw new HttpResponseException($response);
    }
}
