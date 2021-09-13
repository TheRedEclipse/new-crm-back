<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModelHasSlide extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'slide_id',
        'model_type',
        'model_id',
        'usage_type_id',
    ];
}
