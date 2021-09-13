<?php

namespace App\Http\Requests\Api\v1\Material;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMaterialRequest extends FormRequest
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
            'price' => 'required|numeric',
            'title' => 'required',
            'room_type_id' => 'nullable|integer|exists:request_room_types,id',
            'description' => 'nullable|string',
            'csi_code_id' => 'nullable|integer|exists:csi_codes,id',
            'length' => 'nullable|numeric',
            'width' => 'nullable|numeric',
            'height' => 'nullable|numeric',
            'weight' => 'nullable|numeric',
            'dimension_description' => 'nullable|string',
            'rating' => 'nullable|numeric',

            'material_specifications' => 'nullable|array',
            'material_specifications.*.url' => 'nullable|string',
            'material_specifications.*.type' => 'nullable|string',
            'material_specifications.*.path' => 'nullable|string',

            'photos' => 'nullable|array',
            'photos.*.url' => 'nullable|string',
            'photos.*.type' => 'nullable|string',
            'photos.*.path' => 'nullable|string',

            'tags' => 'nullable|array',
            'tags.*' => 'nullable|string',
        ];
    }
}
