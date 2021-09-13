<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserType extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'name',
        'title',
        'description',
    ];

     /**
      * Получение id типа пользователя по названию
      *
      * @param String $name
      * @return \App\Models\LogType
      */
    public static function getIdByName(String $name)
    {
        return Self::whereName($name)->first()->id ?? null;
    }
}
