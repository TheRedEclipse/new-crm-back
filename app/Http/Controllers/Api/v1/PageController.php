<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Page\IndexPageRequest;
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        if ($this->page->where('id', $id)->firstOrFail()) {

            return response()->json([
                'success' => true,
                'data' => [
                    'page' => $this->pageService->show($id),
                ]
            ]);
        }
    }
}
