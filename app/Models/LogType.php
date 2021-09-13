<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class LogType extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

            
     /**
      * Получение id типа лога по названию
      *
      * @param String $name
      * @return \App\Models\LogType
      */
    public static function getIdByName(String $name)
    {
        return Self::whereName($name)->first()->id ?? null;
    }
}
