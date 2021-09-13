<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestWorkAction extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'title',     
        'icon',
        'sort',
    ];

    protected $hidden = [
        'deleted_at',
        'created_at',
        'updated_at',
    ];
}
