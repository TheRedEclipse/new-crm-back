<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'seo_keywords',
        'seo_title',
        'seo_description'
    ];

    public function sliders()
    {
        return $this->morphToMany(
            Slider::class,
            'model',
            'model_has_sliders',
            'model_id',
            'slider_id'
        )->where(['sliders.deleted_at' => NULL]);
    }

    public function textItems()
    {
        return $this->morphToMany(
            TextItem::class,
            'model',
            'page_has_blocks',
            'model_id',
            'page_id'
        )->where(['page_has_blocks.deleted_at' => NULL]);
    }
}
