<?php

namespace App\Services;

use App\Models\Attachment;
use App\Models\AttachmentUsageType;
use App\Models\Log;
use App\Models\Material;
use App\Models\ModelHasAttachment;
use App\Models\ModelHasCsiCode;
use App\Models\ModelHasRoom;
use App\Models\ModelHasTag;
use App\Models\Tag;
use Illuminate\Support\Str;

class MaterialService
{

    protected $material;

    public function __construct(Material $material)
    {

        $this->material = $material;
    }

    public function index(object $request)
    {

        return $this->material->where(['deleted_at' => NULL])->with(['photos', 'materialSpecifications'])->paginate($request->per_page ?? 30);
    }

    public function indexPublic()
    {

        return $this->material->where(['deleted_at' => NULL])->with(['photos'])->get();
    }

    public function store(object $request)
    {

        $user = auth('api')->user();

        $model = Material::class;

        $material = Material::create([
            'price' => $request->price,
            'title' => $request->title,
            'description' => $request->description,
            'height' => $request->height,
            'width' => $request->width,
            'length' => $request->length,
            'weight' => $request->weight,
            'dimension_description' => $request->dimension_description,
            'rating' => $request->rating,
            'sort' => $request->sort,
        ]);


        if ($request->room_type_id) {

            ModelHasRoom::create($request->all() + [
                'room_id' => $request->room_type_id,
                'model_id' => $material->id,
                'model_type' => $model
            ]);
        }

        if ($request->csi_code_id) {

            ModelHasCsiCode::create($request->all() + [
                'csi_code_id' => $request->csi_code_id,
                'model_id' => $material->id,
                'model_type' => $model
            ]);
        }


        if ($request->material_specifications) {

            $materialType = AttachmentUsageType::getIdByName('Material Specification');

            foreach ($request->material_specifications as $material_specification) {

                Attachment::createWithRelation([
                    'model_id' => $material->id,
                    'model_type' => $model,
                    'url' => $material_specification['url'],
                    'path' => $material_specification['path'],
                    'attachment_usage_type_id' => $materialType
                ]);
            }
        }

        if ($request->photos) {

            $photoType = AttachmentUsageType::getIdByName('Photo');

            foreach ($request->photos as $photo) {

                Attachment::createWithRelation([
                    'model_id' => $material->id,
                    'model_type' => $model,
                    'url' => $photo['url'],
                    'path' => $photo['path'],
                    'attachment_usage_type_id' => $photoType
                ]);
            }
        }

        if ($request->tags) {

            foreach ($request->tags as $tag) {

                Tag::createWithRelation([
                    'model_id' => $material->id,
                    'model_type' => $model,
                    'title' => $tag,
                    'slug' => Str::slug($tag, '-')
                ]);
            }
        }

        Log::createWithRelation([
            'model_type' => $model,
            'model_id' =>  $material->id,
            'log_type' => 'MATERIAL_CREATE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} created material #{$material->id}",
            'user_message' => "You've created material #{$material->id}"
        ]);

        return $material->id;
    }
    

    public function show(int $id)
    {
        return $this->material->with(['photos', 'materialSpecifications'])->where('id', $id)->get();
    }


    public function update(object $request, int $id)
    {
        $user = auth('api')->user();

        $model = Material::class;

        if ($request->room_type_id) {

            $room = ModelHasRoom::where([
                'model_id' => $id,
                'model_type' => $model
            ])->first()->toArray();

            if (isset($room)) {

                ModelHasRoom::where([
                    'model_id' => $id,
                    'model_type' => $model
                ])->update([
                    'room_id' => $request->room_type_id
                ]);
            }
        }

        if ($request->csi_code_id) {

            ModelHasCsiCode::where([
                'model_id' => $id,
                'model_type' => $model
            ])->update([
                'csi_code_id' => $request->csi_code_id
            ]);
        }

        // if ($request->material_specifications) {
            $materialType = AttachmentUsageType::getIdByName('Material Specification');

            $materialList = Material::where('id', $id)->with('attachments')->get()->toArray();

            foreach ($materialList as $materialAttachments) {

                foreach ($materialAttachments['attachments']  as $attachment) {

                    if ($attachment['attachment_usage_type_id'] == $materialType) {

                        ModelHasAttachment::where(['attachment_id' => $attachment['id']])->delete();
                    }
                }
            }

            foreach ($request->material_specifications as $material_specification) {

                Attachment::createWithRelation([
                    'model_id' => $id,
                    'model_type' => $model,
                    'url' => $material_specification['url'],
                    'path' => $material_specification['path'] ?? null,
                    'attachment_usage_type_id' => $materialType
                ]);
            }
        // }

        // if ($request->photos) {
            $photoType = AttachmentUsageType::getIdByName('Photo');

            $photoList = Material::where('id', $id)->with('attachments')->get()->toArray();

            foreach ($photoList as $photos) {

                foreach ($photos['attachments']  as $photo) {

                    if ($photo['attachment_usage_type_id'] == $photoType) {

                        ModelHasAttachment::where(['attachment_id' => $photo['id']])->delete();
                    }
                }
            }

            foreach ($request->photos as $photo) {

                Attachment::createWithRelation([
                    'model_id' => $id,
                    'model_type' => $model,
                    'url' => $photo['url'],
                    'path' => $photo['path'] ?? null,
                    'attachment_usage_type_id' => $photoType
                ]);
            }
        // }

        // if ($request->tags) {
            $tags =  ModelHasTag::where(['model_type' => $model, 'model_id' => $id])->get();

            foreach ($tags as $tag) {

                Tag::destroyWithRelation($tag['tag_id']);
            }

            foreach ($request->tags as $tag) {

                Tag::createWithRelation([
                    'model_id' => $id,
                    'model_type' => $model,
                    'title' => $tag,
                    'slug' => Str::slug($tag, '-')
                ]);
            }
        // }

        Material::where('id', $id)->update([
            'price' => $request->price,
            'title' => $request->title,
            'description' => $request->description,
            'height' => $request->height,
            'width' => $request->width,
            'length' => $request->length,
            'weight' => $request->weight,
            'dimension_description' => $request->dimension_description,
            'rating' => $request->rating,
            'sort' => $request->sort,
        ]);

        Log::createWithRelation([
            'model_type' => $model,
            'model_id' =>  $id,
            'log_type' => 'MATERIAL_UPDATE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} updated material #{$id}",
            'user_message' => "You've updated material #{$id}"
        ]);

        return $id;
    }

    public function destroy(int $id)
    {

        $user = auth('api')->user();

        $model = Material::class;

        Material::where('id', $id)->delete();

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

        ModelHasCsiCode::where([
            'model_id' => $id,
            'model_type' => $model
        ])->delete();

        $tags =  ModelHasTag::where(['model_type' => $model, 'model_id' => $id])->get();

        foreach ($tags as $tag) {

            Tag::destroyWithRelation($tag['tag_id']);

        }


        Log::createWithRelation([
            'model_type' => $model,
            'model_id' =>  $id,
            'log_type' => 'MATERIAL_DELETED',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} deleted material #{$id}",
            'user_message' => "You've deleted material category #{$id}"
        ]);

        return $id;
    }
}
