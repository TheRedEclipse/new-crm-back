<?php

namespace App\Http\Controllers\Api\v1\Control;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\TextItem\IndexTextItemRequest;
use App\Http\Requests\Api\v1\TextItem\StoreTextItemRequest;
use App\Http\Requests\Api\v1\TextItem\UpdateTextItemRequest;
use App\Models\TextItem;
use App\Services\TextItemService;

class TextItemController extends Controller
{

    protected $textItemService;


    public function __construct(TextItemService $textItemService, TextItem $textItem)
    {

        $this->textItemService = $textItemService;
        $this->textItem = $textItem;

        $this->middleware(['auth:api', 'permission:admin.text_item.index'])->only(['index', 'all']);
        $this->middleware(['auth:api', 'permission:admin.text_item.by_type'])->only(['byType']);
        $this->middleware(['auth:api', 'permission:admin.text_item.edit'])->only(['edit']);
        $this->middleware(['auth:api', 'permission:admin.text_item.store'])->only(['store']);
        $this->middleware(['auth:api', 'permission:admin.text_item.update'])->only(['update']);
        $this->middleware(['auth:api', 'permission:admin.text_item.destroy.soft'])->only(['destroy']);

    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexTextItemRequest $request)
    {

        return response()->json([

            'success' => true,
            'data' => [
                'text_items' => $this->textItemService->index($request),
            ]

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTextItemRequest $request)
    {

        return response()->json([

            'success' => true,
            'data' => [
                'text_item_id' => $this->textItemService->store($request),
            ],
            'messages' => [__('messages.text_item.store')]

        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        if ($this->textItem->findOrFail($id)) {

            return response()->json([
                'success' => true,
                'data' => [
                    'text_item' => $this->textItemService->show($id),
                ]
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTextItemRequest $request, $id)
    {

        if ($this->textItem->findOrFail($id)) {

            return response()->json([
                'success' => true,
                'data' => [
                    'text_item_id' => $this->textItemService->update($request, $id),
                ],
                'messages' => [__('messages.text_item.update')]
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        if ($this->textItem->findOrFail($id)) {

            return response()->json([
                'success' => true,
                'data' => [
                    'text_item_id' => $this->textItemService->destroy($id),
                ],
                'messages' => [__('messages.text_item.destroy')]
            ]);
        }
    }
}
