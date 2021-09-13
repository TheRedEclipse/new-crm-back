<?php

namespace App\Services;

use App\Models\Attachment;
use App\Models\BuildingType;
use App\Models\Log;
use App\Models\ModelHasAttachment;

class BuildingTypeService
{

    protected $buildingType;

    public function __construct(BuildingType $buildingType)
    {

        $this->buildingType = $buildingType;

    }

    public function index(object $request)
    {

        return BuildingType::filters($request)->where(['deleted_at' => null])->with(['icon'])->get();

    }

    public function paginate(object $request)
    {

        return BuildingType::filters($request)->where(['deleted_at' => null])->with(['icon'])->paginate($request->per_page ?? 30);

    }

    public function all()
    {

        return $this->buildingType->where(['deleted_at' => null])->with(['icon'])->first();

    }

    public function store(object $request)
    {

        $user = auth('api')->user();

        $model = BuildingType::class;

        $buildingType = $this->buildingType->create($request->all());

        if ($request->icon) {
            Attachment::createWithRelation($request->all() + [
                'model_id' => $buildingType->id,
                'model_type' => $model,
                'created_by_id' => $user->id,
                'path' => $request->icon['path'],
                'url' => $request->icon['url'],
            ]);
        }

        Log::createWithRelation([
            'model_type' => $request->model_type ?? $model,
            'model_id' => $request->model_id ?? $buildingType->id,
            'log_type' => 'BUILDING_TYPE_CREATE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} saved building type #{$buildingType->id}",
            'user_message' => "You've saved building type #{$buildingType->id}",
        ]);

        return $buildingType->id;

    }

    public function show(int $id)
    {

        return $this->buildingType->where('id', $id)->with(['icon'])->get();

    }

    public function update(object $request, int $id)
    {

        $user = auth('api')->user();

        $model = BuildingType::class;

        if ($request->icon) {
            ModelHasAttachment::where(['model_id' => $id, 'model_type' => $model])->delete();

            Attachment::createWithRelation($request->all() + [
                'model_id' => $id,
                'model_type' => $model,
                'created_by_id' => $user->id,
                'path' => $request->icon['path'],
                'url' => $request->icon['url'],
            ]);
        }

        $this->buildingType->update($request->all());

        Log::createWithRelation([
            'model_type' => $model,
            'model_id' => $id,
            'log_type' => 'BUILDING_TYPE_UPDATE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} updated building type #{$id}",
            'user_message' => "You've updated building type #{$id}",
        ]);

        return $id;

    }

    public function destroy(int $id)
    {
        $user = auth('api')->user();

        $model = BuildingType::class;

        ModelHasAttachment::where(['model_id' => $id, 'model_type' => $model])->delete();

        $this->buildingType->where(['id' => $id])->delete();

        Log::createWithRelation([
            'model_type' => $model,
            'model_id' => $id,
            'log_type' => 'BUILDING_TYPE_DELETE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} deleted building type #{$id}",
            'user_message' => "You've deleted building type #{$id}",
        ]);

        return $id;
    }

    public function forceDestroy(int $id)
    {
        $user = auth('api')->user();

        $model = BuildingType::class;

        ModelHasAttachment::where(['model_id' => $id, 'model_type' => $model])->delete();

        $this->buildingType->withTrashed()->where(['id' => $id])->forceDelete();

        Log::createWithRelation([
            'model_type' => $model,
            'model_id' => $id,
            'log_type' => 'BUILDING_TYPE_FORCE_DELETE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} force deleted building type #{$id}",
            'user_message' => "You've force deleted building type #{$id}",
        ]);

        return $id;
    }

}
