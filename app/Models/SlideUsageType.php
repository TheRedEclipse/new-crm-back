<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SlideUsageType extends Model
{
    use HasFactory;

    protected $fillable = [
        'usage_type',
        'title'
    ];

    public static function getIdByName($name)
    {
        return Self::whereName($name)->select('id')->first()->id;
    }
}
