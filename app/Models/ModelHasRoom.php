<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelHasRoom extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'model_type',
        'model_id'
    ];
}
