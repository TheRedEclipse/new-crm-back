<?php

namespace App\Services;

use App\Models\Attachment;
use App\Models\Log;
use App\Models\ModelHasAttachment;
use App\Models\ProjectStage;

class ProjectStageService
{

    protected $projectStage;

    public function __construct(ProjectStage $projectStage)
    {

        $this->projectStage = $projectStage;

    }

    public function index(object $request)
    {

        return ProjectStage::filters($request)->where(['deleted_at' => null])->with(['icon'])->get();

    }

    public function paginate(object $request)
    {

        return ProjectStage::filters($request)->where(['deleted_at' => null])->with(['icon'])->paginate($request->per_page ?? 30);

    }

    public function all()
    {

        return $this->projectStage->where(['deleted_at' => null])->with(['icon'])->first();

    }

    public function store(object $request)
    {

        $user = auth('api')->user();

        $model = ProjectStage::class;

        $projectStage = $this->projectStage->create($request->all());

        if ($request->icon) {
            Attachment::createWithRelation($request->all() + [
                'model_id' => $projectStage->id,
                'model_type' => $model,
                'created_by_id' => $user->id,
                'path' => $request->icon['path'],
                'url' => $request->icon['url'],
            ]);
        }

        Log::createWithRelation([
            'model_type' => $request->model_type ?? $model,
            'model_id' => $request->model_id ?? $projectStage->id,
            'log_type' => 'PROJECT_STAGE_CREATE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} saved project stage #{$projectStage->id}",
            'user_message' => "You've saved project stage #{$projectStage->id}",
        ]);

        return $projectStage->id;

    }

    public function show(int $id)
    {

        return $this->projectStage->where('id', $id)->with(['icon'])->get();

    }

    public function update(object $request, int $id)
    {

        $user = auth('api')->user();

        $model = ProjectStage::class;

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

        $this->projectStage->update($request->all());

        Log::createWithRelation([
            'model_type' => $model,
            'model_id' => $id,
            'log_type' => 'PROJECT_STAGE_UPDATE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} updated project stage #{$id}",
            'user_message' => "You've updated project stage #{$id}",
        ]);

        return $id;

    }

    public function destroy(int $id)
    {
        $user = auth('api')->user();

        $model = ProjectStage::class;

        ModelHasAttachment::where(['model_id' => $id, 'model_type' => $model])->delete();

        $this->projectStage->where(['id' => $id])->delete();

        Log::createWithRelation([
            'model_type' => $model,
            'model_id' => $id,
            'log_type' => 'PROJECT_STAGE_DELETE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} deleted project stage #{$id}",
            'user_message' => "You've deleted project stage #{$id}",
        ]);

        return $id;
    }

    public function forceDestroy(int $id)
    {
        $user = auth('api')->user();

        $model = ProjectStage::class;

        ModelHasAttachment::where(['model_id' => $id, 'model_type' => $model])->delete();

        $this->projectStage->withTrashed()->where(['id' => $id])->forceDelete();

        Log::createWithRelation([
            'model_type' => $model,
            'model_id' => $id,
            'log_type' => 'PROJECT_STAGE_FORCE_DELETE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} force deleted project stage #{$id}",
            'user_message' => "You've force deleted project stage #{$id}",
        ]);

        return $id;
    }
 
}