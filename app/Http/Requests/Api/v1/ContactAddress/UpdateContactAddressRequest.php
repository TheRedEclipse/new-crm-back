<?php

namespace App\Http\Requests\Api\v1\ContactAddress;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContactAddressRequest extends FormRequest
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
            'zip' => 'required|integer',
            'state_id' => 'required|exists:states,id',
            'address' => 'required|string',
            'email' => 'required|email',
            'map' => 'nullable|url',
            'phone' => 'nullable|string',
            'latitude' => 'nullable|string',
            'longitude' => 'nullable|string',
        ];
    }
}
