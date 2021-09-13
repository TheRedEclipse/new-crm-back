<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'created_by_id',
        'path',
        'url',
        'type',
        'description',
        'status_id',
        'attachment_usage_type_id'
    ];

    protected $hidden = [
        'path',
    ];

    public static function createWithRelation(array $data)
    {
        $attachment = Self::create($data);
        ModelHasAttachment::create($data + [
            'attachment_id' => $attachment->id
        ]);
        return $attachment;
    }

    public function status()
    {
        return $this->hasOne(Status::class, 'id', 'status_id');
    }

    public function createdBy()
    {
        return $this->hasOne(User::class, 'id', 'created_by_id');
    }

    public function usageType()
    {
        return $this->hasOne(AttachmentUsageType::class, 'id', 'attachment_usage_type_id');
    }
    
}
