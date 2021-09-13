<?php

namespace App\Http\Requests\Api\v1\Work;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWorkRequest extends FormRequest
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
            'price' => 'nullable|integer',
            'size' => 'nullable|integer',
            'kuula_link' => 'nullable|url',
            'room_type_id' => 'required|integer|exists:request_room_types,id',
            'before_photo' => 'nullable|array',
            'before_photo.url' => 'nullable|string',
            'before_photo.path' => 'nullable|string',
            'before_photo.type' => 'nullable|string',
            'after_photo' => 'nullable|array',
            'after_photo.url' => 'nullable|string',
            'after_photo.path' => 'nullable|string',
            'after_photo.type' => 'nullable|string',
            'photos' => 'nullable|array',
            'photos.*.url' => 'nullable|string',
            'photos.*.path' => 'nullable|string',
            'photos.*.type' => 'nullable|string',
        ];
    }
}
