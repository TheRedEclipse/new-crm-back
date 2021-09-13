<?php

namespace App\Http\Requests\Api\v1\Advantage;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdvantageRequest extends FormRequest
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
            'advantage_type_id' => 'integer|exists:advantage_types,id',
            'title' => 'required',
            'sort' => 'integer'
        ];
    }
}
