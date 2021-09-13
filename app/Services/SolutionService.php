<?php

namespace App\Services;

use App\Models\Attachment;
use App\Models\AttachmentUsageType;
use App\Models\Log;
use App\Models\MaterialType;
use App\Models\ModelHasAttachment;
use App\Models\ModelHasMaterial;
use App\Models\ModelHasRoom;
use App\Models\Solution;

class SolutionService
{
    protected $solution;

    public function __construct(Solution $solution)
    {
        $this->solution = $solution;
    }

    public function index(object $request)
    {
        $query = $this->solution
            ->filters($request->filters)
            ->with(['mainMaterials', 'additionalMaterials', 'beforePhoto', 'afterPhoto', 'photos']);

        if(isset($request->filters['room_type_id'])) {
            $query->whereHas('roomTypes', function($query) use ($request) {
                return $query->where('room_id', '=', $request->filters['room_type_id']);
            });
        }
        return (int) $request->per_page ? $query->paginate($request->per_page) : $query->get();
    }

    public function store(object $request)
    {

        $user = auth('api')->user();

        $model = Solution::class;
    
        $solution = Solution::create($request->all());
    
        ModelHasRoom::create(
            $request->all() + [
                'room_id' => $request->room_type_id,
                'model_id' => $solution->id,
                'model_type' => $model
            ]
        );

        if($request->main_materials) {

            $mainId = MaterialType::getIdByName('Main Materials');

            foreach ($request->main_materials as $material)
            {

                ModelHasMaterial::create(
                    $request->all() + [
                        'material_id' => $material,
                        'model_id' => $solution->id,
                        'model_type' => $model,
                        'material_type_id' => $mainId
                    ]
                );
    
            }

        }
    
        if($request->additional_materials) {

            $additionalId = MaterialType::getIdByName('Additional Materials');

            foreach ($request->additional_materials as $material) {
                ModelHasMaterial::create(
                    $request->all() + [
                        'material_id' => $material,
                        'model_id' => $solution->id,
                        'model_type' => $model,
                        'material_type_id' => $additionalId
                    ]
                );
            }
    
        }    

        if (isset($request->before_photo)) {
            Attachment::createWithRelation($request->all() + [
                'model_id' => $solution->id,
                'model_type' => $model,
                'attachment_type_id' => AttachmentUsageType::getIdByName('Before'),
                'url' => $request->before_photo['url'],
                'path'  => $request->before_photo['path']
            ]);
        }

        if (isset($request->after_photo)) {
            Attachment::createWithRelation($request->all() + [
                'model_id' => $solution->id,
                'model_type' => $model,
                'attachment_type_id' => AttachmentUsageType::getIdByName('After'),
                'url' => $request->after_photo['url'],
                'path'  => $request->after_photo['path']
            ]);
        }

        if (isset($request->photos)) {
            foreach ($request->photos as $photo) {
                Attachment::createWithRelation($request->all() + [
                    'model_id' => $solution->id,
                    'model_type' => $model,
                    'attachment_type_id' => AttachmentUsageType::getIdByName('Photos'),
                    'url' => $photo['url'],
                    'path'  => $photo['path']
                ]);
            }
        }

        Log::createWithRelation([
            'model_type' => $request->model_type ?? $model,
            'model_id' => $request->model_id ?? $solution->id,
            'log_type' => 'SOLUTION_CREATE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} updated created solution #{$solution->id}",
            'user_message' => "You've created solution #{$solution->id}"
        ]);

        return $solution->id;
    }

    public function show(int $id)
    {
        return $this->solution
            ->where('id', $id)
            ->with(['mainMaterials.attachments', 'additionalMaterials.attachments', 'beforePhoto', 'afterPhoto', 'photos'])
            ->first();
    }

    public function update(object $request, $id)
    {
        $user = auth('api')->user();
        $model = Solution::class;

        $query = ModelHasRoom::where([
            'model_type' => $model, 
            'model_id' => $id
        ]);

        if($query->count()) {
            $query->update([
                'room_id' => $request->room_type_id
            ]);
        } else {
            ModelHasRoom::create(
                $request->all() + [
                    'room_id' => $request->room_type_id,
                    'model_id' => $id,
                    'model_type' => $model
                ]
            );
        }

        Solution::where('id', $id)
                ->update([
                    'in_popular' => $request->in_popular,
                    'title' => $request->title,
                    'size' => $request->size,
                    'price' => $request->price,
                    'kuula_link' => $request->kuula_link,
                    'description' => $request->description,
                    'seo_title' => $request->seo_title,
                    'seo_description' => $request->seo_description,
                ]);

        $mainId = MaterialType::getIdByName('Main Materials');
        ModelHasMaterial::where(['model_id' => $id, 'model_type' => $model, 'material_type_id' => $mainId])->delete();

        foreach ($request->main_materials as $material) {
            ModelHasMaterial::create(
                $request->all() + [
                    'material_id' => $material,
                    'model_id' => $id,
                    'model_type' => $model,
                    'material_type_id' => $mainId
                ]
            );
        }

        $additionalId = MaterialType::getIdByName('Additional Materials');
        ModelHasMaterial::where(['model_id' => $id, 'model_type' => $model, 'material_type_id' => $additionalId])->delete();

        foreach ($request->additional_materials as $material) {
            ModelHasMaterial::create(
                $request->all() + [
                    'material_id' => $material,
                    'model_id' => $id,
                    'model_type' => $model,
                    'material_type_id' => $additionalId
                ]
            );
        }

        if ($request->before_photo && !isset($request->before_photo['id'])) {
            $beforeId = AttachmentUsageType::getIdByName('Before');

            ModelHasAttachment::where(['attachment_type_id' => $beforeId, 'model_type' => $model, 'model_id' => $id])->delete();
            Attachment::createWithRelation($request->all() + [
                'model_id' => $id,
                'model_type' => $model,
                'attachment_type_id' => $beforeId,
                'url' => $request->before_photo['url'],
                'path'  => $request->before_photo['path'] ?? null
            ]);
        }

        if ($request->after_photo && !isset($request->after_photo['id'])) {
            $afterId = AttachmentUsageType::getIdByName('After');

            ModelHasAttachment::where(['attachment_type_id' => $afterId, 'model_type' => $model, 'model_id' => $id])->delete();
            Attachment::createWithRelation($request->all() + [
                'model_id' => $id,
                'model_type' => $model,
                'attachment_type_id' => $afterId,
                'url' => $request->after_photo['url'],
                'path'  => $request->after_photo['path'] ?? null
            ]);
        }

        if ($request->photos) {
            $photoIds = AttachmentUsageType::getIdByName('Photos');
            ModelHasAttachment::where(['attachment_type_id' => $photoIds, 'model_type' => $model, 'model_id' => $id])->delete();

            foreach ($request->photos as $photo) {
                Attachment::createWithRelation($request->all() + [
                    'model_id' => $id,
                    'model_type' => $model,
                    'attachment_type_id' => $photoIds,
                    'url' => $photo['url'],
                    'path'  => $photo['path'] ?? null
                ]);
            }
        }

        Log::createWithRelation([
            'model_type' => $model,
            'model_id' => $id,
            'log_type' => 'SOLUTION_UPDATE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} updated updated solution #{$request->id}",
            'user_message' => "You've updated solution #{$request->id}"
        ]);

        return $id;
    }

    public function destroy(int $id)
    {
        $user = auth('api')->user();
        $model = Solution::class;

        Solution::where('id', $id)->delete();
        ModelHasRoom::where(['model_type' => $model, 'model_id' => $id])->delete();

        $attachments = ModelHasAttachment::where(['model_id' => $id, 'model_type' => $model])->get()->toArray();

        if (isset($attachments)) {
            foreach ($attachments as $attachment) {
                if ($attachment['deleted_at'] == NULL) {
                    ModelHasAttachment::where([
                        'attachment_id' => $attachment['attachment_id'],
                    ])->delete();
                }
            }
        }

        ModelHasMaterial::where(['model_id' => $id, 'model_type' => $model])->delete();

        $beforeId = AttachmentUsageType::getIdByName('Before');
    
        ModelHasAttachment::where(['attachment_type_id' => $beforeId, 'model_type' => $model, 'model_id' => $id])->delete();

        Log::createWithRelation([
            'model_type' => $model,
            'model_id' => $id,
            'log_type' => 'SOLUTION_DELETE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} updated created solution #{$id}",
            'user_message' => "You've created solution #{$id}"
        ]);

        return $id;
    }
}
