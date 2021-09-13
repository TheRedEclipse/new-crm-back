<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModelHasAttachment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'attachment_id',
        'model_type',
        'model_id',
        'attachment_type_id'
    ];
}
