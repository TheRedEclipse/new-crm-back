<?php

namespace App\Services;

use App\Models\Social;
use App\Models\Log;
use Carbon\Carbon;

class SocialService
{

    protected $social;

    public function __construct(Social $social)
    {
        $this->social = $social;
    }

    public function index(object $request)
    {
        return $this->social->where(['deleted_at' => NULL])->with('attachments')->paginate($request->per_page ?? 30);
    }

    public function all(object $request)
    {
        return $this->social
                    ->whereDeletedAt(null)
                    ->with('attachments')
                    ->get();
    }

    public function store(object $request)
    {

        $user = auth('api')->user();
        
        $model = social::class;

        $work = $this->social->create($request->validated());

        Log::createWithRelation([
            'model_type' => $request->model_type ?? $model,
            'model_id' => $request->model_id ?? $work->id,
            'log_type' => 'SOCIAL_CREATE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} updated created social #{$work->id}",
            'user_message' => "You've created social #{$work->id}"
        ]);

        return $work->id;

    }

    public function show(int $id)
    {

        return $this->social->where('id', $id)->with('attachments')->get();

    }

    public function update(object $request, int $id)
    {

        $user = auth('api')->user();
        $model = social::class;
    
        $this->social->where('id', $id)->update($request->validated());
    
        Log::createWithRelation([
            'model_type' => $model,
            'model_id' => $id,
            'log_type' => 'SOCIAL_UPDATE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} updated social #{$id}",
            'user_message' => "You've updated social #{$id}"
        ]);
    
        return $id;

    }

    public function destroy(int $id)
    {

        $user = auth('api')->user();
        $model = social::class;
    
       $this->social->where('id', $id)->update(['deleted_at' => Carbon::now()->toDateTimeString()]);
    
        Log::createWithRelation([
            'model_type' => $model,
            'model_id' => $id,
            'log_type' => 'SOCIAL_DELETE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} deleted social #{$id}",
            'user_message' => "You've deleted social #{$id}"
        ]);
    
        return $id;
        
    }

}