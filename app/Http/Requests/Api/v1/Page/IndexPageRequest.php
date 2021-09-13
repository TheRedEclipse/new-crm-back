<?php

namespace App\Http\Requests\Api\v1\Page;

use Illuminate\Foundation\Http\FormRequest;

class IndexPageRequest extends FormRequest
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
            'type_id' => 'nullable|integer|exists:page_types,id',
        ];
    }
}
