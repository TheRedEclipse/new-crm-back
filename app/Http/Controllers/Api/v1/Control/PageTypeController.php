<?php

namespace App\Http\Controllers\Api\v1\Control;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\PageType\IndexPageTypeRequest;
use App\Http\Requests\Api\v1\PageType\StorePageTypeRequest;
use App\Http\Requests\Api\v1\PageType\UpdatePageTypeRequest;
use App\Models\PageType;
use App\Services\PageTypeService;

class PageTypeController extends Controller
{

    protected $pageTypeService;
    protected $pageType;


    public function __construct(PageTypeService $pageTypeService, PageType $pageType)
    {

        $this->pageTypeService = $pageTypeService;
        $this->pageType = $pageType;

        $this->middleware(['auth:api', 'permission:admin.page_type.index'])->only(['index', 'all']);
        $this->middleware(['auth:api', 'permission:admin.page_type.by_type'])->only(['byType']);
        $this->middleware(['auth:api', 'permission:admin.page_type.edit'])->only(['edit']);
        $this->middleware(['auth:api', 'permission:admin.page_type.store'])->only(['store']);
        $this->middleware(['auth:api', 'permission:admin.page_type.update'])->only(['update']);
        $this->middleware(['auth:api', 'permission:admin.page_type.destroy.soft'])->only(['destroy']);

    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexPageTypeRequest $request)
    {

        return response()->json([

            'success' => true,
            'data' => [
                'page_types' => $this->pageTypeService->index($request),
            ]

        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {

        return response()->json([

            'success' => true,
            'data' => [
                'page_types' => $this->pageTypeService->all(),
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
    public function store(StorePageTypeRequest $request)
    {

        return response()->json([

            'success' => true,
            'data' => [
                'page_type_id' => $this->pageTypeService->store($request),
            ],
            'messages' => [__('messages.page_type.store')]

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

        if ($this->pageType->findOrFail($id)) {

            return response()->json([
                'success' => true,
                'data' => [
                    'page_type' => $this->pageTypeService->show($id),
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
    public function update(UpdatePageTypeRequest $request, $id)
    {

        if ($this->pageType->findOrFail($id)) {

            return response()->json([
                'success' => true,
                'data' => [
                    'social_platform_id' => $this->pageTypeService->update($request, $id),
                ],
                'messages' => [__('messages.page_type.update')]
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

        if ($this->pageType->findOrFail($id)) {

            return response()->json([
                'success' => true,
                'data' => [
                    'social_platform_id' => $this->pageTypeService->destroy($id),
                ],
                'messages' => [__('messages.page_type.destroy')]
            ]);
        }
    }
}
