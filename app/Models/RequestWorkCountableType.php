<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestWorkCountableType extends Model
{
    use HasFactory;

    protected $fillable = [
        'work_type_id',
        'name',
        'title',
        'icon',
        'min',
        'max',
        'sort',
    ];

    protected $hidden = [
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    public function workType()
    {
        return $this->hasOne(RequestWorkType::class, 'id', 'work_type_id');
    }
}
