<?php

namespace App\Http\Requests\Api\v1\ProjectStage;

use Illuminate\Foundation\Http\FormRequest;

class IndexProjectStageRequest extends FormRequest
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
            'per_page' => 'integer'
        ];
    }
}
