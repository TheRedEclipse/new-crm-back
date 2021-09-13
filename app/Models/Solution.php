<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Solution extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [ 
        'in_popular',        
        'title',
        'size',
        'price',
        'description',
        'kuula_link',
        'seo_title',
        'seo_description'
    ];

    protected $appends = [
        'room_type',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->search_fields = [
            'id',
            'title',
            'size',
            'price',
        ];
        $this->order_fields = [
            'id',
            'title',
            'size',
            'price'
        ];
    }

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

    public function mainMaterials()
    {
        $mainId = MaterialType::getIdByName('Main Materials');

        return $this->morphToMany(
            Material::class,
            'model',
            'model_has_materials',
            'model_id',
            'material_id'
        )->where(['material_type_id' => $mainId, 'model_has_materials.deleted_at' => NULL])->with('photos');
    }

    public function additionalMaterials()
    {
        $additionalId = MaterialType::getIdByName('Additional Materials');

        return $this->morphToMany(
            Material::class,
            'model',
            'model_has_materials',
            'model_id',
            'material_id'
        )->where(['material_type_id' => $additionalId, 'model_has_materials.deleted_at' => NULL])->with('photos');
    }

    public function attachments()
    {
        return $this->morphToMany(
            Attachment::class,
            'model',
            'model_has_attachments',
            'model_id',
            'attachment_id'
        )->where(['deleted_at' => NULL]);
    }

}