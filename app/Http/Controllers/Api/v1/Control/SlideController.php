<?php

namespace App\Http\Controllers\Api\v1\Control;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Slide\ByTypeSlideRequest;
use App\Http\Requests\Api\v1\Slide\IndexSlideRequest;
use App\Http\Requests\Api\v1\Slide\StoreSlideRequest;
use App\Http\Requests\Api\v1\Slide\UpdateSlideRequest;
use App\Models\Slide;
use App\Services\SlideService;

class SlideController extends Controller
{

    protected $slideService;
    protected $slide;

    public function __construct(SlideService $slideService, Slide $slide)
    {

        $this->slideService = $slideService;
        $this->slide = $slide;

        $this->middleware(['auth:api', 'permission:admin.slide.index'])->only(['index', 'all']);
        $this->middleware(['auth:api', 'permission:admin.slide.by_type'])->only(['byType']);
        $this->middleware(['auth:api', 'permission:admin.slide.edit'])->only(['edit']);
        $this->middleware(['auth:api', 'permission:admin.slide.store'])->only(['store']);
        $this->middleware(['auth:api', 'permission:admin.slide.update'])->only(['update']);
        $this->middleware(['auth:api', 'permission:admin.slide.destroy.soft'])->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexSlideRequest $request)
    {

        return response()->json([

            'success' => true,
            'data' => [
                'slides' => $this->slideService->index($request),
            ]

        ]);
    }

        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all(IndexSlideRequest $request)
    {

        return response()->json([

            'success' => true,
            'data' => [
                'slides' => $this->slideService->all($request),
            ]

        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function byType(ByTypeSlideRequest $request)
    {

        return response()->json([

            'success' => true,
            'data' => [
                'slides' => $this->slideService->byType($request),
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
    public function store(StoreSlideRequest $request)
    {

        return response()->json([

            'success' => true,
            'data' => [
                'slide_id' => $this->slideService->store($request),
            ],
            'messages' => [__('messages.slide.store')]

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

        if ($this->slide->findOrFail($id)) {

            return response()->json([
                'success' => true,
                'data' => [
                    'slide' => $this->slideService->show($id),
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
    public function update(UpdateSlideRequest $request, $id)
    {

        if ($this->slide->findOrFail($id)) {

            return response()->json([
                'success' => true,
                'data' => [
                    'slide_id' => $this->slideService->update($request, $id),
                ],
                'messages' => [__('messages.slide.update')]
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

        if ($this->slide->findOrFail($id)) {

            return response()->json([
                'success' => true,
                'data' => [
                    'slide_id' => $this->slideService->destroy($id),
                ],
                'messages' => [__('messages.slide.destroy')]
            ]);
        }
    }
}
