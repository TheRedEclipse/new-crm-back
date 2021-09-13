<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slider extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
    ];

 /*    public static function createWithRelation(object $request, string $model, int $id)
    {

        $modelSlider = Slider::class;

        $slider = Slider::create([
            'title' => $request->slider_title,
            'description' => $request->slider_description,
        ]);

        ModelHasSlider::create([
            'slider_id' => $slider->id,
            'model_id' => $id,
            'model_type' => $model,
        ]);

        foreach ($request->slides as $slide) {

            $slide = Slide::createWithRelation($slide, $modelSlider);

            ModelHasSlide::create([
                'slide_id' => $slide->id,
                'model_id' => $slider->id,
                'model_type' => $modelSlider,

            ]);

        }
    }

    public static function updateWithRelation(object $request, string $model, int $id)
    {

        $modelSlider = Slider::class;

        $sliders = ModelHasSlider::where(['model_id' => $id, 'model_type' => $model])->get();

        foreach ($sliders as $slider) {
            Slider::where(['id' => $slider['slider_id']])->delete();

            $slides = ModelHasSlide::where(['model_id' => $slider['slider_id'], 'model_type' => $modelSlider])->get();

            foreach ($slides as $slide) {
                Slide::where(['id' => $slide['slide_id']])->delete();
            }

            ModelHasSlide::where(['model_id' => $slider['slider_id'], 'model_type' => $modelSlider])->delete();

        }

        ModelHasSlider::where(['model_id' => $id, 'model_type' => $model])->delete();

        $modelSlider = Slider::class;

        $slider = Slider::create([
            'title' => $request->slider_title,
            'description' => $request->slider_description,
        ]);

        ModelHasSlider::create([
            'slider_id' => $slider->id,
            'model_id' => $id,
            'model_type' => $model,
        ]);

        foreach ($request->slides as $slide) {

            $slide = Slide::createWithRelation($slide, $modelSlider);

            ModelHasSlide::create([
                'slide_id' => $slide->id,
                'model_id' => $slider->id,
                'model_type' => $modelSlider,

            ]);

        }

    }

    public static function destroyWithRelation(string $model, int $id)
    {

        $modelSlider = Slider::class;

        $sliders = ModelHasSlider::where(['model_id' => $id, 'model_type' => $model])->get();

        foreach ($sliders as $slider) {
            Slider::where(['id' => $slider['slider_id']])->delete();

            $slides = ModelHasSlide::where(['model_id' => $slider['slider_id'], 'model_type' => $modelSlider])->get();

            foreach ($slides as $slide) {
                Slide::where(['id' => $slide['slide_id']])->delete();
            }

            ModelHasSlide::where(['model_id' => $slider['slider_id'], 'model_type' => $modelSlider])->delete();

        }

        ModelHasSlider::where(['model_id' => $id, 'model_type' => $model])->delete();

    } */

    public function slides()
    {
        return $this->morphToMany(
            Slide::class,
            'model',
            'model_has_slides',
            'model_id',
            'slide_id'
        )->where(['slides.deleted_at' => NULL]);
    }
}
