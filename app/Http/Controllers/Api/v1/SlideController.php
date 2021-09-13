<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Slide\ByTypeSlideRequest;
use App\Http\Requests\Api\v1\Slide\IndexSlideRequest;
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
}
