<?php

namespace App\Services;

use App\Exceptions\PageException;
use App\Models\Log;
use App\Models\ModelHasSlider;
use App\Models\Page;
use App\Models\TextItem;

class PageService
{

    protected $page;

    public function __construct(Page $page)
    {

        $this->page = $page;
    }

    public function index($request)
    {

        return $this->page->where(['deleted_at' => null])->with('sliders.slides', 'textItems')->paginate($request->per_page ?? 30);
        // , 'type_id' => $request->type_id
    }

    public function store(object $request)
    {

        $user = auth('api')->user();

        $model = Page::class;

        $slug = null;

        if (!$request->slug) {

                throw new PageException('Slug already taken. Choose another.');

        }

        $page = $this->page->create([
            'title' => $request->title,
            'description' => $request->description,
            'slug' => $request->slug ?? $slug,
            'seo_keywords' => $request->seo_keywords,
            'seo_title' => $request->seo_title,
            'seo_description' => $request->seo_description,
            'user_id' => $user->id,
        ]);

        if ($request->sliders) {

            foreach ($request->sliders as $slider) {

            ModelHasSlider::create([
                'slider_id' => $slider['id'],
                'model_id' => $page->id,
                'model_type' => $model,
                'type_id' => $slider['type_id'],
                'sort' => $slider['sort']
            ]);

            }

        }

        if ($request->text_items) {

            $textModel = TextItem::class;

            foreach ($request->text_items as $textItem) {

                TextItem::createWithRelation([
                    'page_id' => $page->id,
                    'model_type' => $textModel,
                    'sort' => $textItem['sort'],
                    'title' => $textItem['title'],
                    'description' => $textItem['description'],
                ]);

            }
        }

        Log::createWithRelation([
            'model_type' => $model,
            'model_id' => $page->id,
            'log_type' => 'PAGE_CREATE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} created page #{$page->id}",
            'user_message' => "You've created page #{$page->id}",
        ]);

        return $page->id;
    }

    public function show(int $id)
    {
        return $this->page->where(['id' => $id, 'deleted_at' => null])->with('sliders.slides', 'textitems')->first();
    }

    public function update(object $request, int $id)
    {

        $user = auth('api')->user();

        $model = Page::class;

        $this->page->where('id', $id)->update([
            'title' => $request->title,
            'slug' => $request->slug,
            'description' => $request->description ?? null,
            'seo_keywords' => $request->seo_keywords ?? null,
            'seo_title' => $request->seo_title ?? null,
            'seo_description' => $request->seo_description ?? null,
        ]);

        if ($request->sliders) {

            ModelHasSlider::where([
                'model_id' => $id,
                'model_type' => $model
            ])->delete();

            foreach ($request->sliders as $slider) {

            ModelHasSlider::create([
                'slider_id' => $slider['id'],
                'model_id' => $id,
                'model_type' => $model,
                'type_id' => $slider['type_id'],
                'sort' => $slider['sort']
            ]);

            }

        }

        if ($request->text_items) {

            $textModel = TextItem::class;

            TextItem::destroyWithRelation($textModel, $id);

            foreach ($request->text_items as $textItem) {

                TextItem::createWithRelation([
                    'page_id' => $id,
                    'model_type' => $textModel,
                    'sort' => $textItem['sort'],
                    'title' => $textItem['title'],
                    'description' => $textItem['description'],
                ]);
            }

        }

        Log::createWithRelation([
            'model_type' => $model,
            'model_id' => $id,
            'log_type' => 'PAGE_UPDATE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} updated page #{$id}",
            'user_message' => "You've updated page #{$id}",
        ]);

        return $id;
    }

    public function destroy(int $id)
    {

        $user = auth('api')->user();

        $model = Page::class;

        $this->page->where('id', $id)->delete();

        ModelHasSlider::where([
            'model_id' => $id,
            'model_type' => $model
        ])->delete();

        TextItem::destroyWithRelation(TextItem::class, $id);

        Log::createWithRelation([
            'model_type' => $model,
            'model_id' => $id,
            'log_type' => 'PAGE_DELETED',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} deleted page #{$id}",
            'user_message' => "You've deleted page #{$id}",
        ]);

        return $id;
    }
}
