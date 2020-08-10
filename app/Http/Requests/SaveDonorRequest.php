<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveDonorRequest extends FormRequest
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
            'name'          => 'required',
            'last_name'     => 'required',
            'bloodtype'     => 'required',
            'address'       => 'required',
            'city_id'       => 'required',
            'state_id'      => 'required',
            'postal_code'   => 'required',
            'born_date'     => 'required',
            'email'         => 'required|email',
            'mobile'        => 'required|digits:10|max:10|min:10',
            'weight'        => 'required|numeric',
            'height'        => 'required|numeric',
            'age'           => 'required|numeric',
            'gender'        => 'required'
        ];
    }
}
