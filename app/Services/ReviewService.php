<?php

namespace App\Services;

use App\Models\Attachment;
use App\Models\Log;
use App\Models\ModelHasAttachment;
use App\Models\Review;
use Carbon\Carbon;

class ReviewService
{

    protected $review;

    public function __construct(Review $review)
    {

        $this->review = $review;
    }

    public function index(object $request, $sort = 'DESC')
    {

        return $this->review->where(['deleted_at' => NULL])->with(['user', 'social','avatar'])->orderBy('sort', $sort)->paginate($request->per_page ?? 30);
    }

    public function store(object $request)
    {

        $user = auth('api')->user();

        $model = Review::class;

        $review = $this->review->create($request->all() + ['user_id' => $user->id]);

        if ($request->avatar) {

            Attachment::createWithRelation($request->all() + [
                'model_id' => $review->id,
                'model_type' => $model,
                'created_by_id' => $user->id,
                'path' => $request->avatar['path'],
                'url' => $request->avatar['url']
            ]);
        }

        Log::createWithRelation([
            'model_type' => $model,
            'model_id' =>  $review->id,
            'log_type' => 'REVIEW_CREATE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} created review #{$review->id}",
            'user_message' => "You've created review #{$review->id}"
        ]);

        return $review->id;
    }

    public function show(int $id)
    {
        return $this->review->where('id', $id)->with(['user', 'social', 'avatar'])->first();
    }

    public function update(object $request, int $id)
    {

        $user = auth('api')->user();

        $model = Review::class;

        $this->review->where('id', $id)->update([
            'rate' => $request->rate,
            'social_id' => $request->social_id,
            'sort' => $request->sort,
            'title' => $request->title,
            'name' => $request->name,
            'review_link' => $request->review_link,
            'user_link' => $request->user_link,
            'description' => $request->description,

        ]);

        if (empty($request->avatar['id'])) {

            $attachments = ModelHasAttachment::where(['model_id' => $id, 'model_type' => $model])->get()->toArray();

            if ($attachments) {

                foreach ($attachments as $attachment) {

                    if ($attachment['deleted_at'] == NULL) {

                        ModelHasAttachment::where([
                            'attachment_id' => $attachment['attachment_id'],
                        ])->delete();
                    }
                }

            }

            if(isset($request->avatar)) {
                Attachment::createWithRelation($request->avatar + [
                    'model_id' => $id,
                    'model_type' => $model,
                    'created_by_id' => $user->id,
                    'path' => $request->avatar['path'],
                    'url' => $request->avatar['url']
                ]);
            }

        }

        Log::createWithRelation([
            'model_type' => $model,
            'model_id' =>  $id,
            'log_type' => 'REVIEW_UPDATE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} updated review #{$id}",
            'user_message' => "You've updated review #{$id}"
        ]);

        return $id;
    }

    public function destroy(int $id)
    {

        $user = auth('api')->user();

        $model = Review::class;

        $this->review->where('id', $id)->delete();

        $attachments = ModelHasAttachment::where(['model_id' => $id, 'model_type' => $model])->get();

        if ($attachments) {

            foreach ($attachments as $attachment) {

                if ($attachment['deleted_at'] == NULL) {

                    ModelHasAttachment::where([
                        'attachment_id' => $attachment['attachment_id'],
                    ])->delete();
                }
            }
        }

        Log::createWithRelation([
            'model_type' => $model,
            'model_id' =>  $id,
            'log_type' => 'REVIEW_DELETED',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} deleted review #{$id}",
            'user_message' => "You've deleted review #{$id}"
        ]);

        return $id;
    }
}
