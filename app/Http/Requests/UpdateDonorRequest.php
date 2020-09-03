<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDonorRequest extends FormRequest
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
            'parental_surname' => 'required',
            'maternal_surname' => 'required',
            'address'       => 'required',
            'postal_code'   => 'required',
            'city_id'       => 'required',
            'state_id'      => 'required',
            'bloodtype'     => 'required',
            'gendertype'    => 'required',
            'donortype'    => 'required',
            'born_date'     => 'required',
            'email'         => 'email|unique:donors,email,'.$this->donor->id,
            'mobile'        => 'digits:10|max:10|min:10',
            'weight'        => 'numeric',
            'height'        => 'numeric',
            'age'           => 'required|numeric',
            'observations'  => 'max:255'
        ];
    }
}
