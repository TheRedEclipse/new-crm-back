<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'title',
        'type',
        'color',
        'sort',
        'parent_id',
    ];
    
     /**
      * Получение id статуса по названию и типу
      *
      * @param String $name
      * @return \App\Models\LogType
      */
      public static function getIdByTypeAndName(String $type, String $name)
      {
          return Self::whereName($name)->whereType($type)->first()->id ?? null;
      }
}
