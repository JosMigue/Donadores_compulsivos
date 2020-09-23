<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBloodBankRequest extends FormRequest
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
            'name'        => 'required|max:255',
            'email'       => 'required|email',
            'phone'       => 'required|digits:10',
            'contact_person' => 'required|string|max:255',
            'contact_person_mobile' => 'required|digits:10',
            'address'     => 'required',
            'postal_code' => 'required',
            'city_id'     => 'required',
            'state_id'    => 'required',
            'days' => 'required|array',
            'hyperlink'   => 'nullable|string',
        ];
    }
}
