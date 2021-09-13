<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectStageDate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'title',
        'seconds',
    ];

    protected $hidden = [
        'deleted_at',
        'created_at',
        'updated_at',
    ];
}
