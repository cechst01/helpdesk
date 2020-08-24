<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreTicket extends FormRequest
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
            'project' => 'required|max:100',
            'title' => 'required|max:100',
            'content' => 'required|min:10',
            'date_of_completion_client' => 'required|date_format:d. m. Y|after:yesterday',
            'type_id' => 'required|exists:ticket_types,id',
            'attachments.*' => 'mimes:zip,jpeg,png,pdf,txt,docx,doc|max:4096'
        ];
    }

    public function messages()
    {
       return[
            'project.required'  => 'Musíte vyplnit projekt ke kterému požadavek patří.',
            'project.max' => 'Maximální délka názvu projektu je :max znaků.',
            'title.required'  => 'Musíte vyplnit název požadavku.',
            'title.max' => 'Maximální délka názvu požadavku je :max znaků.',
            'content.required' => 'Musíte vyplnit popis požadavku.',
            'content.min' => 'Minimální délka popisu je :min znaků.',
            'date_of_completion_client.required' => 'Musíte vyplnit požadované datum dokončení.',
            'date_of_completion_client.date_format' => 'Datum není ve správném formátu.',
            'date_of_completion_client.after' => 'Není možné zadat dřívější datum dokončení než zítřejší.',
            'type_id.required' => 'Musíte zadat typ požadavku.',
            'type_id.exists' => 'Zadaný typ požadavku neexistuje.',
            'attachments' => 'max:100',
            'attachments.*.mimes' => 'Je možné vložit pouze soubory s příponou zip jpeg, png, pdf, txt, docx nebo doc.',
            'attachments.*.max' => 'Maximální velikost souboru je 4 MB',

       ];
    }

    protected function failedValidation(Validator $validator)
    {
        //dd($validator->errors()->messages());
        $response = redirect()->route('create-ticket')
                    ->with('error','Formulář není správně vyplněn.')
                    ->withInput()
                    ->withErrors($validator->errors());
        
        throw new HttpResponseException($response);
    }

}
