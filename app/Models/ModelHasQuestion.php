<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelHasQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'model_type',
        'model_id'
    ];
}
