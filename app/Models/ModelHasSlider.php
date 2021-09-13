<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModelHasSlider extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'slider_id',
        'model_type',
        'model_id',
        'type_id',
        'sort'
    ];
}
