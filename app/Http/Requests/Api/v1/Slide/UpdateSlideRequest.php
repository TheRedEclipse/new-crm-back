<?php

namespace App\Http\Requests\Api\v1\Slide;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSlideRequest extends FormRequest
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
            'slide_type_id' => 'integer|exists:slide_types,id',
            'sort' => 'nullable|integer',
            'title' => 'required|string',
            'slide_description' => 'required|string',
            'additional_data' => 'nullable|string',
            'button_text' => 'nullable|string',
            'button_link' => 'nullable|url',

            'image' => 'required|array',
            'image.url' => 'required|url',
            'image.path' => 'required_if:url,=,null',
            'image.attachment_usage_type_id' => 'nullable|integer|exists:attachment_usage_types,id',
        ];
    }
}
