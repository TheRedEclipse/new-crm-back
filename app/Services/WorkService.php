<?php

namespace App\Services;

use App\Models\Attachment;
use App\Models\AttachmentUsageType;
use App\Models\Log;
use App\Models\ModelHasAttachment;
use App\Models\ModelHasMaterial;
use App\Models\ModelHasRoom;
use App\Models\Work;

class WorkService
{

    protected $work;

    public function __construct(Work $work)
    {

        $this->work = $work;

    }

    public function index(object $request)
    {
        $query = $this->work
            ->filters($request->filters)
            ->whereDeletedAt(null)
            ->with(['beforePhoto', 'afterPhoto', 'photos']);

        if(isset($request->filters['room_type_id'])) {
            $query->whereHas('roomTypes', function($query) use ($request) {
                return $query->where('model_id', '=', $request->filters['room_type_id']);
            });
        }
        return (int) $request->per_page ? $query->paginate($request->per_page) : $query->get();
    }

    public function store(object $request)
    {

        $user = auth('api')->user();

        $model = Work::class;

        $work = Work::create($request->all());

        ModelHasRoom::create($request->all() + ['room_id' => $request->room_type_id, 'model_id' => $work->id, 'model_type' => $model]);

        if (isset($request->material_id)) {

            ModelHasMaterial::create($request->all() + [$request->material_id, 'model_id' => $work->id, 'model_type' => $model]);

        }

        if (isset($request->before_image)) {

            Attachment::createWithRelation($request->all() + [
                'model_id' => $work->id,
                'model_type' => $model,
                'attachment_type_id' => AttachmentUsageType::getIdByName('Before'),
                'url' => $request->before_image['url'],
                'path' => $request->before_image['path'],
            ]);

        }

        if (isset($request->after_image)) {

            Attachment::createWithRelation($request->all() + [
                'model_id' => $work->id,
                'model_type' => $model,
                'attachment_type_id' => AttachmentUsageType::getIdByName('After'),
                'url' => $request->before_image['url'],
                'path' => $request->before_image['path'],
            ]);

        }

        if (isset($request->photos)) {

            foreach ($request->photos as $photo) {

                Attachment::createWithRelation($request->all() + [
                    'model_id' => $work->id,
                    'model_type' => $model,
                    'attachment_type_id' => AttachmentUsageType::getIdByName('Photos'),
                    'url' => $photo['url'],
                    'path' => $photo['path'],
                ]);

            }

        }

        Log::createWithRelation([
            'model_type' => $model,
            'model_id' => $work->id,
            'log_type' => 'WORK_CREATE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} updated created work #{$work->id}",
            'user_message' => "You've created work #{$work->id}",
        ]);

        return $work->id;
    }

    public function show(int $id)
    {
        return $this->work
                    ->whereId($id)
                    ->with(['beforePhoto', 'afterPhoto', 'photos'])
                    ->first();
    }

    public function update(object $request, $id)
    {
        $user = auth('api')->user();
        $model = Work::class;

        ModelHasRoom::where(['model_type' => $model, 'model_id' => $id])->update(['room_id' => $request->room_type_id]);

        Work::where('id', $id)->update([
            'title' => $request->title,
            'price' => $request->price,
            'size' => $request->size,
            'kuula_link' => $request->kuula_link,
            'description' => $request->description,
            'seo_title' => $request->seo_title,
            'seo_description' => $request->seo_description,
        ]);

        if ($request->before_photo && !isset($request->before_photo['id'])) {

            $beforeId = AttachmentUsageType::getIdByName('Before');

            ModelHasAttachment::where(['attachment_type_id' => $beforeId, 'model_type' => $model, 'model_id' => $id])->delete();

            Attachment::createWithRelation($request->all() + [
                'model_id' => $id,
                'model_type' => $model,
                'attachment_type_id' => $beforeId,
                'url' => $request->before_photo['url'],
                'path' => $request->before_photo['path'] ?? null
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
                'path' => $request->after_photo['path'] ?? null
            ]);

        }

        if (isset($request->photos)) {

            $photoIds = AttachmentUsageType::getIdByName('Photos');

            ModelHasAttachment::where(['attachment_type_id' => $photoIds, 'model_type' => $model, 'model_id' => $id])->delete();

            foreach ($request->photos as $photo) {

                Attachment::createWithRelation($request->all() + [
                    'model_id' => $id,
                    'model_type' => $model,
                    'attachment_type_id' => $photoIds,
                    'url' => $photo['url'],
                    'path' => $photo['path'] ?? null
                ]);

            }

        }

        Log::createWithRelation([
            'model_type' => $model,
            'model_id' => $id,
            'log_type' => 'WORK_UPDATE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} updated updated work #{$id}",
            'user_message' => "You've updated work #{$id}",
        ]);

        return $id;

    }

    public function destroy(int $id)
    {

        $user = auth('api')->user();

        $model = Work::class;

        Work::where('id', $id)->delete();

        ModelHasRoom::where([
            'model_type' => $model,
            'model_id' => $id,
        ])->delete();

        $attachments = ModelHasAttachment::where([
            'model_id' => $id,
            'model_type' => $model,
        ])->get()->toArray();

        if (isset($attachments)) {

            foreach ($attachments as $attachment) {

                if ($attachment['deleted_at'] == null) {

                    ModelHasAttachment::where([
                        'attachment_id' => $attachment['attachment_id'],
                    ])->delete();
                }
            }
        }

        Log::createWithRelation([
            'model_type' => $model,
            'model_id' => $id,
            'log_type' => 'WORK_DELETE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} updated created work #{$id}",
            'user_message' => "You've created work #{$id}",
        ]);

        return $id;

    }
}
