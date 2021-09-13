<?php

namespace App\Services;

use App\Models\Attachment;
use App\Models\BuildingStage;
use App\Models\Log;
use App\Models\ModelHasAttachment;

class BuildingStageService
{

    protected $buildingStage;

    public function __construct(BuildingStage $buildingStage)
    {

        $this->buildingStage = $buildingStage;

    }

    public function index(object $request)
    {

        return BuildingStage::filters($request)->where(['deleted_at' => null])->with(['icon'])->get();

    }

    public function paginate(object $request)
    {

        return BuildingStage::filters($request)->where(['deleted_at' => null])->with(['icon'])->paginate($request->per_page ?? 30);

    }

    public function all()
    {

        return $this->buildingStage->where(['deleted_at' => null])->with(['icon'])->get();

    }

    public function store(object $request)
    {

        $user = auth('api')->user();

        $model = BuildingStage::class;

        $buildingStage = $this->buildingStage->create($request->all());

        if ($request->icon) {
            Attachment::createWithRelation($request->all() + [
                'model_id' => $buildingStage->id,
                'model_type' => $model,
                'created_by_id' => $user->id,
                'path' => $request->icon['path'],
                'url' => $request->icon['url'],
            ]);
        }

        Log::createWithRelation([
            'model_type' => $request->model_type ?? $model,
            'model_id' => $request->model_id ?? $buildingStage->id,
            'log_type' => 'BUILDING_STAGE_CREATE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} saved building stage #{$buildingStage->id}",
            'user_message' => "You've saved building stage #{$buildingStage->id}",
        ]);

        return $buildingStage->id;

    }

    public function show(int $id)
    {

        return $this->buildingStage->where('id', $id)->with(['icon'])->first();

    }

    public function update(object $request, int $id)
    {

        $user = auth('api')->user();

        $model = BuildingStage::class;

        if ($request->icon) {
            ModelHasAttachment::where([
                'model_id' => $id,
                'model_type' => $model
            ])->delete();

            Attachment::createWithRelation($request->all() + [
                'model_id' => $id,
                'model_type' => $model,
                'created_by_id' => $user->id,
                'path' => $request->icon['path'],
                'url' => $request->icon['url'],
            ]);
        }

        $this->buildingStage->update($request->all());

        Log::createWithRelation([
            'model_type' => $model,
            'model_id' => $id,
            'log_type' => 'BUILDING_STAGE_UPDATE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} updated building stage #{$id}",
            'user_message' => "You've updated building stage #{$id}",
        ]);

        return $id;

    }

    public function destroy(int $id)
    {

        $user = auth('api')->user();

        $model = BuildingStage::class;

        ModelHasAttachment::where([
            'model_id' => $id,
            'model_type' => $model
        ])->delete();

        $this->buildingStage->where(['id' => $id])->delete();

        Log::createWithRelation([
            'model_type' => $model,
            'model_id' => $id,
            'log_type' => 'BUILDING_STAGE_DELETE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} deleted building stage #{$id}",
            'user_message' => "You've deleted building stage #{$id}",
        ]);

        return $id;

    }

    public function forceDestroy(int $id)
    {
        $user = auth('api')->user();

        $model = BuildingStage::class;

        ModelHasAttachment::where([
            'model_id' => $id,
            'model_type' => $model
        ])->delete();

        $this->buildingStage->withTrashed()->where(['id' => $id])->forceDelete();

        Log::createWithRelation([
            'model_type' => $model,
            'model_id' => $id,
            'log_type' => 'BUILDING_STAGE_FORCE_DELETE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} force deleted building stage #{$id}",
            'user_message' => "You've force deleted building stage #{$id}",
        ]);

        return $id;
    }

}