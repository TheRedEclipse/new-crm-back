<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class ModelHasContact extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'contact_id',
        'model_type',
        'model_id'
    ];
}
