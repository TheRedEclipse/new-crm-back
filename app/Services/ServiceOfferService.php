<?php

namespace App\Services;

use App\Models\Attachment;
use App\Models\AttachmentUsageType;
use App\Models\Log;
use App\Models\ModelHasAttachment;
use App\Models\ModelHasRoom;
use App\Models\ModelHasSlide;
use App\Models\ServiceOffer;
use App\Models\SlideUsageType;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class ServiceOfferService 
{
    protected $serviceOffer;


    public function __construct(ServiceOffer $serviceOffer)
    {
        $this->serviceOffer = $serviceOffer;
    }


    public function index(object $request)
    {
        return $this->serviceOffer
                    ->whereDeletedAt(null)
                    ->with(['slides', 'mainSlide', 'beforePhoto', 'afterPhoto', 'mainPhoto'])
                    ->orderBy('sort', 'ASC')
                    ->paginate($request->per_page ?? 30);
    }

    public function all(object $request)
    {
        return $this->serviceOffer
                    ->whereDeletedAt(null)
                    ->with(['slides', 'mainSlide', 'beforePhoto', 'afterPhoto', 'mainPhoto'])
                    ->orderBy('sort', 'ASC')
                    ->get();
    }


    public function store(object $request)
    {
        $user = auth('api')->user();  
        $model = ServiceOffer::class;

        $serviceOffer = $this->serviceOffer->create($request->all(), $model);

        if( !empty($request->room_type_id) ) {
            ModelHasRoom::create(
                $request->all() + [
                    'room_id' => $request->room_type_id,
                    'model_id' => $serviceOffer->id,
                    'model_type' => $model
                ]
            );
        }

        if(is_array($request->slides)) {
            foreach($request->slides as $slide) {
                ModelHasSlide::create([
                    'slide_id' => $slide,
                    'model_id' => $serviceOffer->id,
                    'model_type' => $model,
                    'usage_type_id' => SlideUsageType::getIdByName('page_slider'),
                ]);
            }
        }

        if($request->main_slide) {
            ModelHasSlide::create([
                'slide_id' => $request->main_slide,
                'model_id' => $serviceOffer->id,
                'model_type' => $model,
                'usage_type_id' => SlideUsageType::getIdByName('main_slider'),
            ]);
        }

        if (isset($request->before_photo)) {
            Attachment::createWithRelation($request->validated() + [
                'model_id' => $serviceOffer->id,
                'model_type' => $model,
                'attachment_type_id' => AttachmentUsageType::getIdByName('Before'),
                'url' => $request->before_photo['url'],
                'path'  => $request->before_photo['path'] ?? null
            ]);
        }

        if (isset($request->after_photo)) {
            Attachment::createWithRelation($request->validated() + [
                'model_id' => $serviceOffer->id,
                'model_type' => $model,
                'attachment_type_id' => AttachmentUsageType::getIdByName('After'),
                'url' => $request->after_photo['url'],
                'path'  => $request->after_photo['path'] ?? null
            ]);
        }

        if (isset($request->main_photo)) {
            Attachment::createWithRelation($request->validated() + [
                'model_id' => $serviceOffer->id,
                'model_type' => $model,
                'attachment_type_id' => AttachmentUsageType::getIdByName('main_photo'),
                'url' => $request->main_photo['url'],
                'path'  => $request->main_photo['path'] ?? null
            ]);
        }

        Log::createWithRelation([
            'model_type' => $request->model_type ?? $model,
            'model_id' => $request->model_id ?? $serviceOffer->id,
            'log_type' => 'SERVICE_OFFER_CREATE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} saved service offer #{$serviceOffer->id}",
            'user_message' => "You've saved service offer #{$serviceOffer->id}"
        ]);

        return $serviceOffer->id;
    }


    public function show(int $id)
    {
        return $this->serviceOffer
            ->where('id', $id)
            ->with(['slides', 'mainSlide', 'beforePhoto', 'afterPhoto', 'mainPhoto'])
            ->firstOrFail();
    }


    public function update(object $request, int $id)
    {
        $user = auth('api')->user();
        $model = ServiceOffer::class;

        ModelHasRoom::where([
            'model_type' => $model, 
            'model_id' => $id
        ])->delete();

        if( !empty($request->room_type_id) ) {
            ModelHasRoom::create(
                $request->all() + [
                    'room_id' => $request->room_type_id,
                    'model_id' => $id,
                    'model_type' => $model
                ]
            );
        }

        $this->serviceOffer
            ->where('id', $id)
            ->update(Arr::except($request->validated(), [
                'main_slide', 'slides', 'before_photo', 'after_photo', 'main_photo', 'room_type_id'
            ]));

        ModelHasSlide::where([
            'model_id' => $id,
            'model_type' => $model
        ])->delete();

        if(is_array($request->slides)) {
            foreach($request->slides as $slide) {
                ModelHasSlide::create([
                    'model_id' => $id,
                    'model_type' => $model,
                    'slide_id' => $slide,
                    'usage_type_id' => SlideUsageType::getIdByName('page_slider'),
                ]);
            }
        }
        
        ModelHasSlide::create([
            'slide_id' => $request->main_slide,
            'model_id' => $id,
            'model_type' => $model,
            'usage_type_id' => SlideUsageType::getIdByName('main_slider'),
        ]);

        if (!isset($request->before_photo['id'])) {
            $beforeId = AttachmentUsageType::getIdByName('Before');

            ModelHasAttachment::where(['attachment_type_id' => $beforeId, 'model_type' => $model, 'model_id' => $id])->delete();
            
            if(isset($request->before_photo)) {
                Attachment::createWithRelation($request->validated() + [
                    'model_id' => $id,
                    'model_type' => $model,
                    'attachment_type_id' => $beforeId,
                    'url' => $request->before_photo['url'],
                    'path'  => $request->before_photo['path'] ?? null
                ]);
            }
        }

        if (!isset($request->after_photo['id'])) {
            $afterId = AttachmentUsageType::getIdByName('After');

            ModelHasAttachment::where(['attachment_type_id' => $afterId, 'model_type' => $model, 'model_id' => $id])->delete();

            if(isset($request->after_photo)) {
                Attachment::createWithRelation($request->validated() + [
                    'model_id' => $id,
                    'model_type' => $model,
                    'attachment_type_id' => $afterId,
                    'url' => $request->after_photo['url'],
                    'path'  => $request->after_photo['path'] ?? null
                ]);
            }
        }

        if (!isset($request->main_photo['id'])) {
            $type_id = AttachmentUsageType::getIdByName('main_photo');

            ModelHasAttachment::where(['attachment_type_id' => $type_id, 'model_type' => $model, 'model_id' => $id])->delete();

            if(isset($request->main_photo)) {
                Attachment::createWithRelation($request->validated() + [
                    'model_id' => $id,
                    'model_type' => $model,
                    'attachment_type_id' => $type_id,
                    'url' => $request->main_photo['url'],
                    'path'  => $request->main_photo['path'] ?? null
                ]);
            }
        }

        Log::createWithRelation([
            'model_type' => $model,
            'model_id' => $id,
            'log_type' => 'SERVICE_OFFER_UPDATE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} updated service offer #{$id}",
            'user_message' => "You've updated service offer #{$id}"
        ]);

        return $id;
    }


    public function destroy(int $id)
    {
        $user = auth('api')->user();
        $model = ServiceOffer::class;

        $this->serviceOffer->where('id', $id)->delete();

        ModelHasSlide::where([
            'model_id' => $id,
            'model_type' => $model
        ])->delete();

        Log::createWithRelation([
            'model_type' => $model,
            'model_id' => $id,
            'log_type' => 'SERVICE_OFFER_DELETE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} deleted service offer #{$id}",
            'user_message' => "You've deleted service offer #{$id}"
        ]);

        return $id;
    }
}