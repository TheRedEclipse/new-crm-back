<?php

namespace App\Http\Requests\Api\v1\Page;

use Illuminate\Foundation\Http\FormRequest;

class StorePageRequest extends FormRequest
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
            'title' => 'required',
            'slug'  => 'nullable|unique:pages,slug',
            'sliders' => 'nullable|array',
            'sliders.*.id' => 'nullable|integer|exists:sliders,id',
            'sliders.*.type_id' => 'nullable|integer|exists:slider_types,id',
            'sliders.*.sort' => 'nullable|integer',
            'text_items' => 'nullable|array',
            'text_items.*.title' => 'nullable|string',
            'text_items.*.description' => 'nullable|string',
            'text_items.*.sort' => 'nullable|string'
        ];
    }
}
