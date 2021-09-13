<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestHasRoom extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_id',
        'room_type_id',
        'renovation_type_id',
        'length',
        'width',
        'height',
        'description',
        'pinterest_link'
    ];

    public function roomType()
    {
        return $this->hasOne(RequestRoomType::class, 'id', 'room_type_id');
    }

    public function renovationType()
    {
        return $this->hasOne(RequestRenovationType::class, 'id', 'renovation_type_id');
    }

    public function works()
    {
        return $this->hasMany(RequestRoomHasWork::class, 'room_id')->with('workType')->with('workAction')->with('doubleCurrent')->with('doubleReplace');
    }

    public function countable()
    {
        return $this->hasMany(RequestRoomHasWorkCountable::class, 'room_id')->with('countableType');
    }

    public function styles()
    {
        return $this->hasMany(RequestRoomHasStyle::class, 'room_id')->with('workStyle');
    }

    public function styleAttachments()
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
