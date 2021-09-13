<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestRoomHasWorkCountable extends Model
{
    use HasFactory;

    protected $table = 'request_room_has_work_countable';

    protected $fillable = [
        'room_id',
        'countable_type_id',
        'count',
    ];

    public function countableType()
    {
        return $this->hasOne(RequestWorkCountableType::class, 'id', 'countable_type_id')->with('workType');
    }
}
