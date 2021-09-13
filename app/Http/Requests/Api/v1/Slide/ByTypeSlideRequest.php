<?php

namespace App\Http\Requests\Api\v1\Slide;

use Illuminate\Foundation\Http\FormRequest;

class ByTypeSlideRequest extends FormRequest
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
            'slide_type_id' => 'required|integer|exists:slide_types,id',
            'type' => 'integer|exists:slide_types,id',
            'per_page' => 'integer'
        ];
    }
}
