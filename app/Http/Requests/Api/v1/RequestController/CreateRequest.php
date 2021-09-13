<?php

namespace App\Http\Requests\Api\v1\RequestController;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
            'user_id' => 'nullable|exists:users,id',
            'email' => request()->has('user_id') ? '' : 'required|email:rfc,dns|unique:users,email',
            'address' => 'nullable|string',
            'zip' => 'nullable|integer',
            'name' => 'nullable|string',
            'last_name' => 'nullable|string',
            'new_lead' => 'nullable',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'phone' => 'nullable|integer',
            'state' => 'nullable|string',
            'building_type_id' => 'required|integer|exists:building_types,id',
            'building_stage_id' => 'required|integer|exists:building_stages,id',
            'project_stage_date_id' => 'required|integer|exists:project_stage_dates,id',
            'rooms' => 'required|array',
            'rooms.*.description' => 'nullable|string',
            'rooms.*.pinterest_link' => 'nullable|url',
            'rooms.*.length' => 'required|integer',
            'rooms.*.height' => 'required|integer',
            'rooms.*.width' => 'required|integer',
            'rooms.*.room_type_id' => 'required|integer|exists:request_room_types,id',
            'rooms.*.renovation_type_id' => 'required|integer|exists:request_renovation_types,id',
            'rooms.*.countable.*.countable_type_id' => 'nullable|integer|exists:request_work_countable_types,id',
            'rooms.*.countable.*.count' => 'nullable|integer',
            'rooms.*.styles.*.id' => 'nullable|integer|exists:request_room_styles,id',
            'rooms.*.works.*.work_type_id' => 'required|integer|exists:request_work_types,id',
            'rooms.*.works.*.work_action_id' => 'required|integer|exists:request_work_actions,id',
            'rooms.*.works.*.quantity' => 'nullable|integer',
            'rooms.*.works.*.double_current_id' => 'nullable|integer|exists:request_work_replaces,id',
            'rooms.*.works.*.double_replace_id' => 'nullable|integer|exists:request_work_replaces,id',
            'rooms.*.style_attachments.*.url' => 'nullable|url',
            'rooms.*.style_attachments.*.path' => 'nullable|url',
        ];
    }
}
