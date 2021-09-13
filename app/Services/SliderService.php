<?php

namespace App\Services;

use App\Models\Log;
use App\Models\ModelHasSlide;
use App\Models\Slide;
use App\Models\Slider;

class SliderService
{
    protected $slider;

    public function __construct(Slider $slider)
    {
        $this->slider = $slider;
    }

    public function index(object $request)
    {
        return $this->slider
                    ->whereDeletedAt(null)
                    ->with(['slides.attachments'])
                    ->paginate($request->per_page ?? 30);
    }

    public function all()
    {
        return $this->slider
                    ->whereDeletedAt(null)
                    ->with(['slides.attachments'])
                    ->get();
    }

    public function store(object $request)
    {
        $user = auth('api')->user();

        $model = Slider::class;

        if ($request->slides) {

            $slider = $this->slider->create([
                'title' => $request->slider_title,
                'description' => $request->slider_description,
            ]);

            foreach ($request->slides as $slideId) {

                ModelHasSlide::create([
                    'slide_id' => $slideId,
                    'model_id' => $slider->id,
                    'model_type' => $model,
                ]);

            }

        }

        Log::createWithRelation([
            'model_type' => $request->model_type ?? $model,
            'model_id' => $request->model_id ?? $slider->id,
            'log_type' => 'SLIDE_CREATE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} saved slider #{$slider->id}",
            'user_message' => "You've saved slider #{$slider->id}",
        ]);

        return $slider->id;
    }

    public function show(int $id)
    {
        return $this->slider->where('id', $id)->with(['slides.attachments'])->first();
    }

    public function update(object $request, int $id)
    {
        $user = auth('api')->user();

        $model = Slider::class;

        if ($request->slides) {
            $this->slider->where(['id' => $id])->update([
                'title' => $request->slider_title,
                'description' => $request->slider_description,
            ]);

            ModelHasSlide::where([
                'model_id' => $id,
                'model_type' => $model,
            ])->delete();

            foreach ($request->slides as $slideId) {

                ModelHasSlide::create([
                    'slide_id' => $slideId,
                    'model_id' => $id,
                    'model_type' => $model,
                ]);

            }
        }

        Log::createWithRelation([
            'model_type' => $model,
            'model_id' => $id,
            'log_type' => 'SLIDE_UPDATE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} updated slider #{$id}",
            'user_message' => "You've updated slider #{$id}",
        ]);

        return $id;
    }

    public function destroy(int $id)
    {
        $user = auth('api')->user();
        $model = Slider::class;

        ModelHasSlide::where([
            'model_id' => $id,
            'model_type' => $model,
        ])->delete();

        $this->slider->where([
            'id' => $id
        ])->delete();

        Log::createWithRelation([
            'model_type' => $model,
            'model_id' => $id,
            'log_type' => 'SLIDE_DELETE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} deleted slider #{$id}",
            'user_message' => "You've deleted slider #{$id}",
        ]);

        return $id;
    }
}
