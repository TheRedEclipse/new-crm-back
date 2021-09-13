<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'slug'
    ];

    public static function createWithRelation(array $data)
    {
        $tag = Self::create($data);
        ModelHasTag::create($data + [
            'tag_id' => $tag->id
        ]);
        return $tag;
    }

    public static function destroyWithRelation(int $id)
    {
        Self::where(['id' => $id])->delete();

        ModelHasTag::where(['tag_id' => $id])->delete();
    }
    
}
