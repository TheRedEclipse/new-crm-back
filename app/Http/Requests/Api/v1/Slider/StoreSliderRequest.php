<?php

namespace App\Http\Requests\Api\v1\Slider;

use Illuminate\Foundation\Http\FormRequest;

class StoreSliderRequest extends FormRequest
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
            'title' => 'required|string',
            'description' => 'nullable|string',
            'slider_title' => 'nullable|string',
            'slider_description' => 'nullable|string',
            'slider_type' => 'nullable|integer|exists:slider_types,id',
            'slider_sort' => 'nullable|integer',
            'slides' => 'nullable|array',
            'slides.*' => 'nullable|integer|exists:slides,id',
        ];
    }
}
