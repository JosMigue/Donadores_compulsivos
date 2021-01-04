<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveIndividualDonationRequest extends FormRequest
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
            'bloodbank_id' => 'required|integer',
            'donor_id' => 'required|integer',
            'date_donation' => 'required|date',
            'time_donation' => 'required|date_format:H:i',
            'donationtype' => 'required'
        ];
    }
}
