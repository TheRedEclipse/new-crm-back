<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Solution\IndexSolutionRequest;
use App\Models\Solution;
use App\Services\SolutionService;

class SolutionController extends Controller
{

    protected $solutionService;
    protected $solution;

    public function __construct(SolutionService $solutionService, Solution $solution)
    {
        $this->solutionService = $solutionService;
        $this->solution = $solution;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexSolutionRequest $request)
    {

        return response()->json([

            'success' => true,
            'data' => [
                'solutions' => $this->solutionService->index($request),
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
        if ($this->solution->findOrFail($id)) {

            return response()->json([
                'success' => true,
                'data' => [
                    'solution' => $this->solutionService->show($id),
                ]
            ]);
        }
    }
}
