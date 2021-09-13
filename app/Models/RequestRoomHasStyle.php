<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestRoomHasStyle extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'room_id',
        'style_id',
    ];
    
    public function workStyle()
    {
        return $this->hasOne(RequestRoomStyle::class, 'id', 'style_id');
    }
}
