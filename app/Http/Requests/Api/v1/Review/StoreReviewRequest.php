<?php

namespace App\Http\Requests\Api\v1\Review;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
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
            'rate' => 'required|numeric|min:1|max:5',
            'title' => 'required',
            'description' => 'nullable|string',
            'social_id' => 'nullable|integer|exists:socials,id',
            'avatar' => 'nullable|array',
            'avatar.url' => 'nullable|string',
            'avatar.path' => 'nullable|string',
            'sort' => 'nullable|integer',
            'place' => 'nullable|string',
            'review_link' => 'nullable|url',
            'user_link' => 'nullable|url'
        ];
    }
}
