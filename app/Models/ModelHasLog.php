<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class ModelHasLog extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'log_id',
        'model_type',
        'model_id'
    ];
}
