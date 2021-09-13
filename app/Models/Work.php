<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Work extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'size',
        'price',
        'kuula_link',
        'description',
        'seo_title',
        'seo_description'
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
        );
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
            'model_has_attachments.deleted_at' => NULL
        ]);
    }

    public function photos()
    {
        return $this->morphToMany(
            Attachment::class,
            'model',
            'model_has_attachments',
            'model_id',
            'attachment_id'
        )->where([
            'attachment_type_id' => AttachmentUsageType::getIdByName('Photos'),
            'model_has_attachments.deleted_at' => NULL
        ]);
    }

    public function attachments()
    {
        return $this->morphToMany(
            Attachment::class,
            'model',
            'model_has_attachments',
            'model_id',
            'attachment_id'
        );
    }
}
