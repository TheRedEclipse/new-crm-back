<?php

namespace App\Services;

use App\Models\Log;
use App\Models\Slide;

class SlideService 
    {

    protected $slide;

    public function __construct(Slide $slide)
    {
        $this->slide = $slide;
    }

    public function index(object $request)
    {
        $query = $this->slide
            ->filters($request->filters)
            ->with(['slideType', 'image.usageType']);

        if(isset($request->filters['slide_type'])) {
            $query->whereHas('slideType', function($query) use ($request) {
                return $query->where('name', '=', $request->filters['slide_type']);
            });
        }

        if(isset($request->filters['slide_type_id'])) {
            $query->whereHas('slideType', function($query) use ($request) {
                return $query->where('id', '=', $request->filters['slide_type_id']);
            });
        }

        return (int) $request->per_page ? $query->paginate($request->per_page) : $query->get();
    }

    public function all()
    {
        return $this->slide
                    ->where([
                        'deleted_at' => NULL
                    ])
                    ->with([
                        'slideType',
                        'attachments.usageType'
                    ])
                    ->get();
    }

    public function byType(object $request)
    {
        return $this->slide
                    ->where([
                        'deleted_at' => NULL,
                        'slide_type_id' => $request->slide_type_id
                    ])
                    ->with([
                        'slideType',
                        'attachments.usageType'
                    ])
                    ->paginate($request->per_page ?? 30);
    }

    public function store(object $request)
    {
        $user = auth('api')->user();
            
        $model = Slide::class;

        $slide = $this->slide->createWithRelation($request->validated(), $model);

        Log::createWithRelation([
            'model_type' => $request->model_type ?? $model,
            'model_id' => $request->model_id ?? $slide->id,
            'log_type' => 'SLIDE_CREATE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} saved slide #{$slide->id}",
            'user_message' => "You've saved slide #{$slide->id}"
        ]);

        return $slide->id;
    }

    public function show(int $id)
    {
        return $this->slide->where('id', $id)->with(['slideType', 'attachments.usageType'])->get();
    }

    public function update(object $request, int $id)
    {
        $user = auth('api')->user();
        $model = Slide::class;

        $this->slide->updateWithRelation($request->validated(), $model, $id);

        Log::createWithRelation([
            'model_type' => $model,
            'model_id' => $id,
            'log_type' => 'SLIDE_UPDATE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} updated slide #{$id}",
            'user_message' => "You've updated slide #{$id}"
        ]);

        return $id;
    }

    public function destroy(int $id)
    {
        $user = auth('api')->user();
        $model = Slide::class;

        $this->slide->destroyWithRelation($model, $id);

        Log::createWithRelation([
            'model_type' => $model,
            'model_id' => $id,
            'log_type' => 'SLIDE_DELETE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} deleted slide #{$id}",
            'user_message' => "You've deleted slide #{$id}"
        ]);

        return $id;
    }

}