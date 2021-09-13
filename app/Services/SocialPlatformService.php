<?php

namespace App\Services;

use App\Models\Log;
use App\Models\SocialPlatform;

class SocialPlatformService 
{

protected $socialPlatform;

public function __construct(SocialPlatform $socialPlatform)
{

    $this->socialPlatform = $socialPlatform;
    
}

public function index(object $request)
{

    return $this->socialPlatform->where(['deleted_at' => NULL])->paginate($request->per_page ?? 30);

}

public function all()
{

    return $this->socialPlatform->where(['deleted_at' => NULL])->get();

}

public function store(object $request)
{

    $user = auth('api')->user();
        
    $model = socialPlatform::class;

    $socialPlatform = $this->socialPlatform->create($request->all());

    Log::createWithRelation([
        'model_type' => $request->model_type ?? $model,
        'model_id' => $request->model_id ?? $socialPlatform->id,
        'log_type' => 'SOCIAL_PLATFORM_CREATE',
        'from_user_id' => $user->id,
        'message' => "User {$user->name} {$user->last_name} saved Social Platform #{$socialPlatform->id}",
        'user_message' => "You've saved Social Platform #{$socialPlatform->id}"
    ]);

    return $socialPlatform->id;


}

public function show(int $id)
{

    return $this->socialPlatform->where('id', $id)->get();

}

public function update(object $request, int $id)
{

    $user = auth('api')->user();
    $model = socialPlatform::class;

    $this->socialPlatform->where('id', $id)->update($request->all());

    Log::createWithRelation([
        'model_type' => $model,
        'model_id' => $id,
        'log_type' => 'SOCIAL_PLATFORM_UPDATE',
        'from_user_id' => $user->id,
        'message' => "User {$user->name} {$user->last_name} updated Social Platform #{$id}",
        'user_message' => "You've updated Social Platform #{$id}"
    ]);

    return $id;


}

public function destroy(int $id)
{

    $user = auth('api')->user();
    $model = socialPlatform::class;

   $this->socialPlatform->where('id', $id)->delete();

    Log::createWithRelation([
        'model_type' => $model,
        'model_id' => $id,
        'log_type' => 'SOCIAL_PLATFORM_DELETE',
        'from_user_id' => $user->id,
        'message' => "User {$user->name} {$user->last_name} deleted Social Platform #{$id}",
        'user_message' => "You've deleted Social Platform #{$id}"
    ]);

    return $id;


}

}