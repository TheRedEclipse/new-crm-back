<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'created_by_id'
    ];

    // public static function withModel($model_type, $model_id) {
    //     return belongsTo(ModelHasNote::class, 'note_id')->has('model_id', $model_id);
    // }

    public static function createWithRelation(array $data)
    {
        $note = Self::create($data);
        ModelHasNote::create($data + [
            'note_id' => $note->id
        ]);
        return $note;
    }
}