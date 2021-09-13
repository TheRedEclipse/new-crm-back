<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TextItem extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description'
    ];

    public static function createWithRelation(array $request)
    {

        $textItem = Self::create($request);

        PageHasBlock::create($request + [
            'model_id' => $textItem->id
        ]);

        return $textItem;
    }

    public static function destroyWithRelation(string $model, int $id)
    {
        $blocks = PageHasBlock::where([
            'model_type' => $model,
            'page_id' => $id
        ])->get()->toArray();

        foreach ($blocks as $block) {

            Self::where('id', $block['model_id'])->delete();
        }

        PageHasBlock::where([
            'model_type' => $model,
            'page_id' => $id
        ])->delete();

        return $id;
    }
}
