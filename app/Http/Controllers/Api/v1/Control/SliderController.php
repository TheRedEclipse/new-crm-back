<?php

namespace App\Http\Controllers\Api\v1\Control;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Slider\IndexSliderRequest;
use App\Http\Requests\Api\v1\Slider\StoreSliderRequest;
use App\Http\Requests\Api\v1\Slider\UpdateSliderRequest;
use App\Models\Slider;
use App\Services\SliderService;

class SliderController extends Controller
{

    protected $sliderService;
    protected $slider;

    public function __construct(SliderService $sliderService, Slider $slider)
    {

        $this->sliderService = $sliderService;
        $this->slider = $slider;

        $this->middleware(['auth:api', 'permission:admin.slider.index'])->only(['index', 'all']);
        $this->middleware(['auth:api', 'permission:admin.slider.by_type'])->only(['byType']);
        $this->middleware(['auth:api', 'permission:admin.slider.edit'])->only(['edit']);
        $this->middleware(['auth:api', 'permission:admin.slider.store'])->only(['store']);
        $this->middleware(['auth:api', 'permission:admin.slider.update'])->only(['update']);
        $this->middleware(['auth:api', 'permission:admin.slider.destroy.soft'])->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexSliderRequest $request)
    {

        return response()->json([

            'success' => true,
            'data' => [
                'sliders' => $this->sliderService->index($request),
            ]

        ]);
    }

        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all(IndexSliderRequest $request)
    {

        return response()->json([

            'success' => true,
            'data' => [
                'sliders' => $this->sliderService->all($request),
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
    public function store(StoreSliderRequest $request)
    {

        return response()->json([

            'success' => true,
            'data' => [
                'slider_id' => $this->sliderService->store($request),
            ],
            'messages' => [__('messages.slider.store')]

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

        if ($this->slider->findOrFail($id)) {

            return response()->json([
                'success' => true,
                'data' => [
                    'slider' => $this->sliderService->show($id),
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
    public function update(UpdateSliderRequest $request, $id)
    {

        if ($this->slider->findOrFail($id)) {

            return response()->json([
                'success' => true,
                'data' => [
                    'slider_id' => $this->sliderService->update($request, $id),
                ],
                'messages' => [__('messages.slider.update')]
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

        if ($this->slider->findOrFail($id)) {

            return response()->json([
                'success' => true,
                'data' => [
                    'slider_id' => $this->sliderService->destroy($id),
                ],
                'messages' => [__('messages.slider.destroy')]
            ]);
        }
    }
}
