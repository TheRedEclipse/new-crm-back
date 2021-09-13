<?php

namespace App\Services;

use App\Models\Log;
use App\Models\TextItem;

class TextItemService 
{

protected $textItem;

public function __construct(TextItem $textItem)
{

    $this->textItem = $textItem;
    
}

public function index(object $request)
{

    return $this->textItem->where(['deleted_at' => NULL])->paginate($request->per_page ?? 30);

}

public function store(object $request)
{

    $user = auth('api')->user();
        
    $model = TextItem::class;

    $textItem = $this->textItem->create($request->all());

    Log::createWithRelation([
        'model_type' => $request->model_type ?? $model,
        'model_id' => $request->model_id ?? $textItem->id,
        'log_type' => 'TEXT_ITEM_CREATE',
        'from_user_id' => $user->id,
        'message' => "User {$user->name} {$user->last_name} saved Text Item #{$textItem->id}",
        'user_message' => "You've saved Text Item #{$textItem->id}"
    ]);

    return $textItem->id;


}

public function show(int $id)
{

    return $this->textItem->where('id', $id)->get();

}

public function update(object $request, int $id)
{

    $user = auth('api')->user();
    $model = TextItem::class;

    $this->textItem->where('id', $id)->update($request->all());

    Log::createWithRelation([
        'model_type' => $model,
        'model_id' => $id,
        'log_type' => 'TEXT_ITEM_UPDATE',
        'from_user_id' => $user->id,
        'message' => "User {$user->name} {$user->last_name} updated Text Item #{$id}",
        'user_message' => "You've updated Text Item #{$id}"
    ]);

    return $id;


}

public function destroy(int $id)
{

    $user = auth('api')->user();
    $model = TextItem::class;

   $this->textItem->where('id', $id)->delete();

    Log::createWithRelation([
        'model_type' => $model,
        'model_id' => $id,
        'log_type' => 'TEXT_ITEM_DELETE',
        'from_user_id' => $user->id,
        'message' => "User {$user->name} {$user->last_name} deleted Text Item #{$id}",
        'user_message' => "You've deleted Text Item #{$id}"
    ]);

    return $id;


}

}