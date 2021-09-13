<?php

namespace App\Actions;

use App\Exceptions\LeadException;
use App\Models\Lead;
use App\Models\Log;
use App\Models\Status;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateLeadAction
{
    use AsAction;

    public function handle($request, string $type = 'lead', $with_address = true)
    {
        $user = request()->user('api');
        
        if(
            (!$user && $request->user_id)
            || ( $user && $user->id !== $request->user_id && !$user->hasPermissionTo('lead.store.other'))
        ) {
            throw new LeadException('no_perms_to_create_to_others');
        }
        
        $new_user = [];
        if(!$request->user_id) {
            $new_user = User::create($request->all() + [
                'type_id' => UserType::getIdByName($type),
                'password' => Hash::make(Str::random(16)),
            ]);
            $new_user->syncRoles(['lead']);
        }

        $lead_content = $request->all() + [
            'status_id' => Status::getIdByTypeAndName($type, 'new'),
            'user_id' => $request->user_id ?? $new_user->id,
            'created_by_id' => $user->id ?? $new_user->id
        ];

        $lead = $with_address ? Lead::createWithAddress($lead_content) : Lead::create($lead_content);

        $user = $user ?? $new_user;
        Log::createWithRelation([
            'model_type' => $request->model_type ?? Lead::class,
            'model_id' => $request->model_id ?? $lead->id,
            'log_type' => 'LEAD_CREATE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} created a lead #{$lead->id}",
            'user_message' => "You created a lead #{$lead->id}"
        ]);

        return [$lead, $new_user];
    }
}
