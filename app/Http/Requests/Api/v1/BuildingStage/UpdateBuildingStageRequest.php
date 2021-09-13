<?php

namespace App\Http\Requests\Api\v1\BuildingStage;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBuildingStageRequest extends FormRequest
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
            'name' => 'required|string',
            'title' => 'required|string',
            'icon' => 'nullable|array',
            'icon.path' => 'nullable|string',
            'icon.url' => 'nullable|string'
        ];
    }
}
