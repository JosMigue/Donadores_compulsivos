<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveBloodBankRequest extends FormRequest
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
            'email'       => 'required|email|unique:blood_banks',
            'phone'       => 'required|digits:10',
            'contact_person' => 'required|string|max:255',
            'address'     => 'required',
            'postal_code' => 'required',
            'city_id'     => 'required',
            'state_id'    => 'required',
            'user_id'     => 'required',
            'dayofweektype' => 'required',
            'bussines_hours_start' => 'required',
            'bussines_hours_end' => 'required',

        ];
    }
}
