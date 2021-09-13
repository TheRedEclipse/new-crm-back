<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'price',
        'title',
        'description',
        'width',
        'height',
        'length',
        'weight',
        'dimension_description',
        'rating',
        'sort'
    ];

    protected $appends = [
        'room_type',
        'tags',
    ];

    public function getRoomTypeAttribute() 
    {
        return $this->roomTypes()->first();
    }

    public function getTagsAttribute() 
    {
        return $this->tags()->pluck('title');
    }

    public function roomTypes()
    {
        return $this->morphToMany(
            RequestRoomType::class,
            'model',
            'model_has_rooms',
            'model_id',
            'room_id'
        )->where(['deleted_at' => NULL]);
    }

    public function tags()
    {
        return $this->morphToMany(
            Tag::class,
            'model',
            'model_has_tags',
            'model_id',
            'tag_id'
        );
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

    public function photos()
    {

        $type = AttachmentUsageType::where(['usage_type' => 'Photo'])->first();

        return $this->morphToMany(
            Attachment::class,
            'model',
            'model_has_attachments',
            'model_id',
            'attachment_id',
        )->where(['attachment_usage_type_id' => $type->id, 'deleted_at' => NULL]);
    }

    public function materialSpecifications()
    {
        $type = AttachmentUsageType::where(['usage_type' => 'Material Specification'])->first();

        return $this->morphToMany(
            Attachment::class,
            'model',
            'model_has_attachments',
            'model_id',
            'attachment_id',
        )->where(['attachment_usage_type_id' => $type->id, 'deleted_at' => NULL]);
    }

}
