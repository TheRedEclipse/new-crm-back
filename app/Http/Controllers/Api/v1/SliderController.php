<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Slider\IndexSliderRequest;
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

}
