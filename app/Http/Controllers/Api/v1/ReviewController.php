<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Review\IndexReviewRequest;
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
                'reviews' => $this->reviewService->index($request, 'ASC'),
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

        if ($this->review->findOrFail($id)) {

            return response()->json([
                'success' => true,
                'data' => [
                    'review' => $this->reviewService->show($id),
                ]
            ]);
        }
    }
}
