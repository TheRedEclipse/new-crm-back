<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PageHasBlock extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'page_id',
        'model_type',
        'model_id',
        'sort'
    ];
}
