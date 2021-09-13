<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SlideType extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'name',
        'title'
    ];

    public static function getIdByName($name) {
        return Self::whereName($name)->select('id')->first()->id ?? null;
    }
}
