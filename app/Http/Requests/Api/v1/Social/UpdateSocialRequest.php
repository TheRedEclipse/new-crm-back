<?php

namespace App\Http\Requests\Api\v1\Social;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSocialRequest extends FormRequest
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
            'icon' => 'required|string',
            'url' => 'required|url',
            'title' => 'required|string',
            'description' => 'nullable|string',
        ];
    }
}
