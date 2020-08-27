<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveCampaignRequest extends FormRequest
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
            'name'      => 'required|max:255',
            'place'     => 'required|max:255',
            'description' => 'required|max:255',
            'city_id'  => 'required|numeric',
            'state_id'  => 'required|numeric',
            'date_start'=> 'required|date',
            'time_start'=> 'required',
            'date_finish'=> 'required|date',
            'time_finish'=> 'required',
            'description'=> 'required',
            'user_id' =>    'required',
        ];
    }
}
