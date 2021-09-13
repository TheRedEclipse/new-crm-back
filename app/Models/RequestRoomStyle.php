<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestRoomStyle extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'sort',       
        'room_type_id',  
        'is_checked',  
    ];

    protected $hidden = [
        'deleted_at',
        'created_at',
        'updated_at',
    ];
}
