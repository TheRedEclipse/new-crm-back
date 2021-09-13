<?php

namespace App\Http\Controllers\Api\v1\Control;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Review\IndexReviewRequest;
use App\Http\Requests\Api\v1\Review\StoreReviewRequest;
use App\Http\Requests\Api\v1\Review\UpdateReviewRequest;
use App\Models\Review;
use App\Services\ReviewService;

class ReviewController extends Controller
{

    protected $previewService;
    protected $review;

    public function __construct(ReviewService $reviewService, Review $review)
    {

        $this->reviewService = $reviewService;
        $this->review = $review;

        $this->middleware(['auth:api', 'permission:admin.review.index'])->only(['index', 'all']);
        $this->middleware(['auth:api', 'permission:admin.review.edit'])->only(['edit']);
        $this->middleware(['auth:api', 'permission:admin.review.store'])->only(['store']);
        $this->middleware(['auth:api', 'permission:admin.review.update'])->only(['update']);
        $this->middleware(['auth:api', 'permission:admin.review.destroy.soft'])->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexReviewRequest $request)
    {

        return response()->json([

            'success' => true,
            'data' => [
                'reviews' => $this->reviewService->index($request),
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
                'reviews' => $this->review->all(),
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
    public function store(StoreReviewRequest $request)
    {

        return response()->json([

            'success' => true,
            'data' => [
                'review_id' => $this->reviewService->store($request),
            ],
            'messages' => [__('messages.review.store')]

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

        if ($this->review->findOrFail($id)) {

            return response()->json([
                'success' => true,
                'data' => [
                    'review' => $this->reviewService->show($id),
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
    public function update(UpdateReviewRequest $request, $id)
    {

        if ($this->review->findOrFail($id)) {

            return response()->json([
                'success' => true,
                'data' => [
                    'review_id' => $this->reviewService->update($request, $id),
                ],
                'messages' => [__('messages.review.update')]
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

        if ($this->review->findOrFail($id)) {

            return response()->json([
                'success' => true,
                'data' => [
                    'review_id' => $this->reviewService->destroy($id),
                ],
                'messages' => [__('messages.review.destroy')]
            ]);
        }
    }
}
