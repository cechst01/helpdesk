<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateIpAddresses extends FormRequest
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
            'allowedIp.*' => 'ip',
        ];
    }

    public function messages()
    {
        return[
            'user_name.*'  => 'Musíte zadat platnou ip adresu.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = redirect()->route('edit-allowed-ip')
            ->with('error','Neplatná Ip adresa.')
            ->withInput()
            ->withErrors($validator->errors());

        throw new HttpResponseException($response);
    }
}
