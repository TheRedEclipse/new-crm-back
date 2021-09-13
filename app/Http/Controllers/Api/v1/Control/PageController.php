<?php

namespace App\Http\Controllers\Api\v1\Control;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Page\IndexPageRequest;
use App\Http\Requests\Api\v1\Page\StorePageRequest;
use App\Http\Requests\Api\v1\Page\UpdatePageRequest;
use App\Models\Page;
use App\Services\PageService;

class PageController extends Controller
{

    protected $pageService;
    protected $page;

    public function __construct(PageService $pageService, Page $page)
    {

        $this->pageService = $pageService;
        $this->page = $page;

        $this->middleware(['auth:api', 'permission:admin.page.index'])->only(['index', 'all']);
        $this->middleware(['auth:api', 'permission:admin.page.edit'])->only(['edit']);
        $this->middleware(['auth:api', 'permission:admin.page.store'])->only(['store']);
        $this->middleware(['auth:api', 'permission:admin.page.update'])->only(['update']);
        $this->middleware(['auth:api', 'permission:admin.page.destroy.soft'])->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexPageRequest $request)
    {

        return response()->json([

            'success' => true,
            'data' => [
                'pages' => $this->pageService->index($request),
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
                'pages' => $this->page->all(),
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
    public function store(StorePageRequest $request)
    {
         $page = $this->pageService->store($request);


         if($page == 'error') {

            return response()->json([

                'success' => false,
                'errors' => [__('messages.page.slug')]
    
            ]);
        }

        return response()->json([

            'success' => true,
            'data' => [
                'page_id' => $page,
            ],
            'messages' => [__('messages.page.store')]

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

            return response()->json([
                'success' => true,
                'data' => [
                    'page' => $this->pageService->show($id),
                ]
            ]);
        
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
    public function update(UpdatePageRequest $request, $id)
    {

        if ($this->page->findOrFail($id)) {

            return response()->json([
                'success' => true,
                'data' => [
                    'page_id' => $this->pageService->update($request, $id),
                ],
                'messages' => [__('messages.page.update')]
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

        if ($this->page->findOrFail($id)) {

            return response()->json([
                'success' => true,
                'data' => [
                    'page_id' => $this->pageService->destroy($id),
                ],
                'messages' => [__('messages.page.destroy')]
            ]);
        }
    }
}
