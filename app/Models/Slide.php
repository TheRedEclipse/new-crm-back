<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slide extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'slide_type_id',
        'sort',
        'title',
        'slide_description',
        'additional_data',
        'button_text',
        'button_link'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->search_fields = [
            'slide_type_id',
            'title',
            'slide_description',
        ];
        $this->order_fields = [
            'id',
            'sort',
            'title',
            'additional_data'
        ];
    }

    public static function createWithRelation(array $data, string $model)
    {

        $slide = Self::create($data);

        if (isset($data['image'])) {

            Attachment::createWithRelation($data['image'] + [
                'model_id' => $slide->id,
                'model_type' => $model
            ]);
        }

        return $slide;
    }

    public static function updateWithRelation(array $data, string $model, int $id)
    {

        Self::where('id', $id)->update([
            'slide_type_id' => $data['slide_type_id'] ?? null,
            'sort' => $data['sort'] ?? null,
            'title' => $data['title'],
            'slide_description' => $data['slide_description'] ?? null,
            'additional_data' => $data['additional_data'] ?? null,
            'button_link' => $data['button_link'] ?? null,
            'button_text' => $data['button_text'] ?? null,
        ]);

      if(isset($data['image'])) {

        $attachments = ModelHasAttachment::where(['model_id' => $id, 'model_type' => $model])->get()->toArray();

        if ($attachments) {

            foreach ($attachments as $attachment) {

                ModelHasAttachment::where([
                    'attachment_id' => $attachment['attachment_id'],
                ])->update(['deleted_at' => Carbon::now()->toDateTimeString()]);
            }

            Attachment::createWithRelation($data['image'] + [
                'model_id' => $id,
                'model_type' => $model
            ]);
        }
    }
    }

    public static function destroyWithRelation(string $model, int $id)
    {

        $timestamp = Carbon::now()->toDateTimeString();

        Self::where('id', $id)->update(['deleted_at' => $timestamp]);

        $attachments = ModelHasAttachment::where(['model_id' => $id, 'model_type' => $model])->get()->toArray();

        if (isset($attachments)) {

            foreach ($attachments as $attachment) {

                if ($attachment['deleted_at'] == NULL) {

                    ModelHasAttachment::where([
                        'attachment_id' => $attachment['attachment_id'],
                    ])->update(['deleted_at' => Carbon::now()->toDateTimeString()]);
                }
            }
        }
    }

    public function slideType()
    {
        return $this->hasOne(SlideType::class, 'id', 'slide_type_id');
    }

    public function attachments()
    {
        return $this->morphToMany(
            Attachment::class,
            'model',
            'model_has_attachments',
            'model_id',
            'attachment_id'
        )->whereDeletedAt(null);
    }

    public function image()
    {
        return $this->morphToMany(
            Attachment::class,
            'model',
            'model_has_attachments',
            'model_id',
            'attachment_id'
        )->whereDeletedAt(null);
    }
}
