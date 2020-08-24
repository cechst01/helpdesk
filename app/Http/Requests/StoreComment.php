<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreComment extends FormRequest
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
            'author_name' => 'required|max:100',
            'content' => 'required'
        ];
    }

    public function messages(){
        return[
            'author_name.required' => 'Vaše jméno musí být vyplněno.',
            'author_name.max' => 'Maximální délka jména je: :max znaků.',
            'content.required' => 'Popis musí být vyplněn.'
        ];
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
