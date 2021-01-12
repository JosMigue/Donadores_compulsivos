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
            'maternal_surname' => 'nullable',
            'curp' => 'required|string|max:18|min:18|unique:donors,curp,'.$this->donor->id.'|unique:temporal_donors',
            'city_id'       => 'required',
            'state_id'      => 'required',
            'bloodtype'     => 'required',
            'gendertype'    => 'nullable',
            'donortype'    => 'required',
            'born_date'     => 'required',
            'first_time_donating' => 'boolean',
            'be_the_match' => 'boolean',
            'letter' => 'boolean',
            'email'         => 'nullable|email|unique:donors,email,'.$this->donor->id.'|unique:temporal_donors',
            'mobile'        => 'nullable|digits:10|max:10|min:10',
            'age'           => 'required|numeric',
            'observations'  => 'max:255'
        ];
    }
}
