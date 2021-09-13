<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModelHasMaterial extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'material_id',
        'model_type',
        'model_id',
        'material_type_id'
    ];
}
