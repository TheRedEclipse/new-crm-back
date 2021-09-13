<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelHasNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'note_id',
        'model_type',
        'model_id'
    ];
}
