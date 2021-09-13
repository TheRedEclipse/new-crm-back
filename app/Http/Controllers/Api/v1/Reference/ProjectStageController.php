<?php

namespace App\Http\Controllers\Api\v1\Reference;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\ProjectStage\IndexProjectStageRequest;
use App\Http\Requests\Api\v1\ProjectStage\StoreProjectStageRequest;
use App\Http\Requests\Api\v1\ProjectStage\UpdateProjectStageRequest;
use App\Models\ProjectStage;
use App\Services\ProjectStageService;

class ProjectStageController extends Controller
{

    protected $projectStageService;
    protected $projectStage;

    public function __construct(ProjectStageService $projectStageService, ProjectStage $projectStage)
    {

        $this->projectStageService = $projectStageService;
        $this->projectStage = $projectStage;
        $this->middleware(['auth:api', 'permission:reference.project_stage.index'])->only(['index', 'all']);
        $this->middleware(['auth:api', 'permission:reference.project_stage.edit'])->only(['edit']);
        $this->middleware(['auth:api', 'permission:reference.project_stage.store'])->only(['store']);
        $this->middleware(['auth:api', 'permission:reference.project_stage.update'])->only(['update']);
        $this->middleware(['auth:api', 'permission:reference.project_stage.destroy.soft'])->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexProjectStageRequest $request)
    {

        return response()->json([

            'success' => true,
            'data' => [
                'project_stages' => $this->projectStageService->index($request),
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
                'project_stages' => $this->projectStageService->all(),
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
    public function store(StoreProjectStageRequest $request)
    {

        return response()->json([
            'success' => true,
            'data' => [
                'project_stage_id' => $this->projectStageService->store($request),
            ],
            'messages' => [__('messages.project_stage.store')]

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

        if ($this->projectStage->findOrFail($id)) {
            return response()->json([
                'success' => true,
                'data' => [
                    'project_stage' => $this->projectStageService->show($id),
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
    public function update(UpdateProjectStageRequest $request, $id)
    {

        if ($this->projectStage->findOrFail($id)) {
            return response()->json([
                'success' => true,
                'data' => [
                    'project_stage_id' => $this->projectStageService->update($request, $id),
                ],
                'messages' => [__('messages.project_stage.update')]
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

        if ($this->projectStage->findOrFail($id)) {
            return response()->json([
                'success' => true,
                'data' => [
                    'project_stage_id' => $this->projectStageService->destroy($id),
                ],
                'messages' => [__('messages.project_stage.destroy')]
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function forceDestroy($id)
    {

        if ($this->projectStage->withTrashed()->findOrFail($id)) {
            return response()->json([
                'success' => true,
                'data' => [
                    'project_stage_id' => $this->projectStageService->forceDestroy($id),
                ],
                'messages' => [__('messages.project_stage.force_destroy')]
            ]);
        }
    }
}
