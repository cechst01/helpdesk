<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProcessNewTicket extends FormRequest
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
            'date_of_completion' => 'required|date_format:d. m. Y|after_or_equal:today',
            'credits_offer' => 'sometimes|required|numeric'
        ];
    }

    public function messages(){

        $messages = [
            'date_of_completion.required' => 'Datum dokončení musí být zadáno.',
            'date_of_completion.date' => 'Datum není ve správném formátu.',
            'date_of_completion.after_or_equal' => 'Není možné zadat dřívější datum dokončení než dnešní.',
            'credits_offer.required' => 'Pro odeslání požadavku ke schválení rozpočtu je nutné vyplnit odhadovaný počet hodin.',
            'credits_offer.numeric' => 'Počet hodin musí být číslo.',
        ];

        return $messages ;
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
