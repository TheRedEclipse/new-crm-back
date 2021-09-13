<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceOffer extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'block_title',
        'block_description',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'sort'
    ];

    protected $appends = [
        'room_type',
    ];

    public function getRoomTypeAttribute() 
    {
        return $this->roomTypes()->first();
    }

    public function roomTypes()
    {
        return $this->morphToMany(
            RequestRoomType::class,
            'model',
            'model_has_rooms',
            'model_id',
            'room_id'
        )->where('model_has_rooms.deleted_at', null);
    }

    public function slides()
    {
        return $this->morphToMany(
                        Slide::class,
                        'model',
                        'model_has_slides',
                        'model_id',
                        'slide_id'
                    )
                    ->where('model_has_slides.deleted_at', null)
                    ->where('usage_type_id', SlideUsageType::getIdByName('page_slider'))
                    ->with('image');
    }

    public function mainSlide()
    {
        return $this->morphToMany(
                        Slide::class,
                        'model',
                        'model_has_slides',
                        'model_id',
                        'slide_id'
                    )
                    ->where('model_has_slides.deleted_at', null)
                    ->where('usage_type_id', SlideUsageType::getIdByName('main_slider'))
                    ->with('image');
    }

    public function beforePhoto()
    {
        return $this->morphToMany(
                        Attachment::class,
                        'model',
                        'model_has_attachments',
                        'model_id',
                        'attachment_id'
                    )->where([
                        'attachment_type_id' => AttachmentUsageType::getIdByName('Before'),
                        'model_has_attachments.deleted_at' => NULL
                    ]);
    }

    public function afterPhoto()
    {
        return $this->morphToMany(
                        Attachment::class,
                        'model',
                        'model_has_attachments',
                        'model_id',
                        'attachment_id'
                    )->where([
                        'attachment_type_id' => AttachmentUsageType::getIdByName('After'),
                        'model_has_attachments.deleted_at' => null
                    ]);
    }

    public function mainPhoto()
    {
        return $this->morphToMany(
                        Attachment::class,
                        'model',
                        'model_has_attachments',
                        'model_id',
                        'attachment_id'
                    )->where([
                        'attachment_type_id' => AttachmentUsageType::getIdByName('main_photo'),
                        'model_has_attachments.deleted_at' => null
                    ]);
    }

}
