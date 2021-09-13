<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialType extends Model
{
    use HasFactory;

    public $timestamps = false;

    public static function getIdByName($name) {

        return Self::whereName($name)->first()->id;

    }

}
