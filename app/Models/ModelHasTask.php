<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelHasTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'model_type',
        'model_id'
    ];
}
