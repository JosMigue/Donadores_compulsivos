<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminRequest extends FormRequest
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
            'name'      =>   'required|string|max:255',
            'email'     =>   'required|string|max:255|unique:users,email,'.$this->user->id.'|unique:donors|unique:temporal_donors',
            'profile_picture'     =>  'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'captured_image'    => 'nullable|string',
        ];
    }
}
