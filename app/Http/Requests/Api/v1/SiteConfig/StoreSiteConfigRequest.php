<?php

namespace App\Http\Requests\Api\v1\SiteConfig;

use Illuminate\Foundation\Http\FormRequest;

class StoreSiteConfigRequest extends FormRequest
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
            'email' => 'email',
            'link_terms' => 'url',
            'link_policy' => 'url',
            'states' => 'array',
            "states.*"  => "string|min:2",
            "logo" => 'array',
            'logo.url' => 'nullable|string',
            'logo.path' => 'nullable|string',

        ];
    }
}
