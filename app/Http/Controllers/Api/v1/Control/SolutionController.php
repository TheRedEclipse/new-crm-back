<?php

namespace App\Http\Controllers\Api\v1\Control;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Solution\IndexSolutionRequest;
use App\Http\Requests\Api\v1\Solution\StoreSolutionRequest;
use App\Http\Requests\Api\v1\Solution\UpdateSolutionRequest;
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

        $this->middleware(['auth:api', 'permission:admin.solution.index'])->only(['index', 'all']);
        $this->middleware(['auth:api', 'permission:admin.solution.edit'])->only(['edit']);
        $this->middleware(['auth:api', 'permission:admin.solution.store'])->only(['store']);
        $this->middleware(['auth:api', 'permission:admin.solution.update'])->only(['update']);
        $this->middleware(['auth:api', 'permission:admin.solution.destroy.soft'])->only(['destroy']);
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        return response()->json([

            'success' => true,
            'data' => [
                'solutions' => $this->solution->all(),
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
    public function store(StoreSolutionRequest $request)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'solution_id' => $this->solutionService->store($request),
            ],
            'messages' => [__('messages.solution.store')]
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
    public function update(UpdateSolutionRequest $request, $id)
    {
        if ($this->solution->findOrFail($id)) {
            return response()->json([
                'success' => true,
                'data' => [
                    'solution_id' => $this->solutionService->update($request, $id),
                ],
                'messages' => [__('messages.solution.update')]
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
        if ($this->solution->findOrFail($id)) {
            return response()->json([
                'success' => true,
                'data' => [
                    'solution_id' => $this->solutionService->destroy($id),
                ],
                'messages' => [__('messages.solution.destroy')]
            ]);
        }
    }
}
