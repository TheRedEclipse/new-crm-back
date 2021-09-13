<?php

namespace App\Services;

use App\Models\Log;
use App\Models\PageType;

class PageTypeService
{

    protected $pageType;

    public function __construct(PageType $pageType)
    {

        $this->pageType = $pageType;

    }

    public function index(object $request)
    {

        return $this->pageType->where(['deleted_at' => null])->paginate($request->per_page ?? 30);

    }

    public function all()
    {

        return $this->pageType->where(['deleted_at' => null])->get();

    }

    public function store(object $request)
    {

        $user = auth('api')->user();

        $model = PageType::class;

        $pageType = $this->pageType->create($request->all());

        Log::createWithRelation([
            'model_type' => $request->model_type ?? $model,
            'model_id' => $request->model_id ?? $pageType->id,
            'log_type' => 'PAGE_TYPE_CREATE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} saved Page Type #{$pageType->id}",
            'user_message' => "You've saved Page Type #{$pageType->id}",
        ]);

        return $pageType->id;

    }

    public function show(int $id)
    {

        return $this->pageType->where('id', $id)->get();

    }

    public function update(object $request, int $id)
    {

        $user = auth('api')->user();
        $model = PageType::class;

        $this->pageType->where('id', $id)->update($request->all());

        Log::createWithRelation([
            'model_type' => $model,
            'model_id' => $id,
            'log_type' => 'PAGE_TYPE_UPDATE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} updated Page Type #{$id}",
            'user_message' => "You've updated Page Type #{$id}",
        ]);

        return $id;

    }

    public function destroy(int $id)
    {

        $user = auth('api')->user();
        $model = PageType::class;

        $this->pageType->where('id', $id)->delete();

        Log::createWithRelation([
            'model_type' => $model,
            'model_id' => $id,
            'log_type' => 'PAGE_TYPE_DELETE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} deleted Page Type #{$id}",
            'user_message' => "You've deleted Page Type #{$id}",
        ]);

        return $id;

    }

}
