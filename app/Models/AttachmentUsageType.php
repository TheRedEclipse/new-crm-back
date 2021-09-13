<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttachmentUsageType extends Model
{
    use HasFactory;

    public static function getIdByName($name) {
        return Self::whereUsageType($name)->first()->id;
    }
}
