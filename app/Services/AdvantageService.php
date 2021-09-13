<?php

namespace App\Services;

use App\Models\Advantage;
use App\Models\Log;
use Carbon\Carbon;

class AdvantageService 
{

protected $advantage;

public function __construct(Advantage $advantage)
{
    $this->advantage = $advantage;
}


public function index(object $request)
{

    return $this->advantage->where('deleted_at', NULL)->with(['advantageType'])->orderBy('sort', 'DESC')->paginate($request->per_page ?? 30);

}

public function store(object $request)
{

    $user = auth('api')->user();
        
    $model = Advantage::class;

    $advantage = $this->advantage->create($request->all(), $model);

    Log::createWithRelation([
        'model_type' => $request->model_type ?? $model,
        'model_id' => $request->model_id ?? $advantage->id,
        'log_type' => 'ADVANTAGE_CREATE',
        'from_user_id' => $user->id,
        'message' => "User {$user->name} {$user->last_name} saved advantage #{$advantage->id}",
        'user_message' => "You've saved advantage #{$advantage->id}"
    ]);

    return $advantage->id;


}

public function show(int $id)
{

    return $this->advantage->where('id', $id)->with(['advantagetypes'])->orderBy('sort', 'DESC')->get();

}

public function update(object $request, int $id)
{

    $user = auth('api')->user();
    $model = Advantage::class;

    $this->advantage->where('id', $id)->update($request->all());

    Log::createWithRelation([
        'model_type' => $model,
        'model_id' => $id,
        'log_type' => 'ADVANTAGE_UPDATE',
        'from_user_id' => $user->id,
        'message' => "User {$user->name} {$user->last_name} updated advantage #{$id}",
        'user_message' => "You've updated advantage #{$id}"
    ]);

    return $id;


}

public function destroy(int $id)
{

    $user = auth('api')->user();
    $model = Advantage::class;

   $this->advantage->where('id', $id)->update(['deleted_at' => Carbon::now()->toDateTimeString()]);

    Log::createWithRelation([
        'model_type' => $model,
        'model_id' => $id,
        'log_type' => 'ADVANTAGE_DELETE',
        'from_user_id' => $user->id,
        'message' => "User {$user->name} {$user->last_name} deleted advantage #{$id}",
        'user_message' => "You've deleted advantage #{$id}"
    ]);

    return $id;


}

}