<?php

namespace App\Http\Requests\Api\v1\ServiceOffer;

use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceOfferRequest extends FormRequest
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
            'room_type_id' => 'nullable|integer|exists:request_room_types,id',
            'title' => 'required|string',
            'slides' => 'nullable|array',
            'slides.*' => 'nullable|integer|exists:slides,id',
            'main_slide' => 'nullable|integer|exists:slides,id',
            'sort' => 'nullable|integer',
            'seo_title' => 'nullable|string',
            'description' => 'nullable|string',
            'seo_description' => 'nullable|string',
            'before_photo' => 'nullable|array',
            'before_photo.url' => 'nullable|string',
            'before_photo.path' => 'nullable|string',
            'before_photo.type' => 'nullable|string',
            'after_photo' => 'nullable|array',
            'after_photo.url' => 'nullable|string',
            'after_photo.path' => 'nullable|string',
            'after_photo.type' => 'nullable|string',

            'main_photo' => 'nullable|array',
            'main_photo.url' => 'nullable|string',
            'main_photo.path' => 'nullable|string',
            'main_photo.type' => 'nullable|string',
        ];
    }
}
