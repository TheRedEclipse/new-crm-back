<?php

namespace App\Http\Controllers\Api\v1\Reference;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\BuildingStage\IndexBuildingStageRequest;
use App\Http\Requests\Api\v1\BuildingStage\StoreBuildingStageRequest;
use App\Http\Requests\Api\v1\BuildingStage\UpdateBuildingStageRequest;
use App\Models\BuildingStage;
use App\Services\BuildingStageService;

class BuildingStageController extends Controller
{

    protected $buildingStageService;
    protected $buildingStage;

    public function __construct(BuildingStageService $buildingStageService, BuildingStage $buildingStage)
    {
        $this->buildingStageService = $buildingStageService;
        $this->buildingStage = $buildingStage;

        $this->middleware(['auth:api', 'permission:reference.building_stage.index'])->only(['index', 'all']);
        $this->middleware(['auth:api', 'permission:reference.building_stage.edit'])->only(['edit']);
        $this->middleware(['auth:api', 'permission:reference.building_stage.store'])->only(['store']);
        $this->middleware(['auth:api', 'permission:reference.building_stage.update'])->only(['update']);
        $this->middleware(['auth:api', 'permission:reference.building_stage.destroy.soft'])->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexBuildingStageRequest $request)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'building_stages' => $this->buildingStageService->index($request),
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
                'building_stages' => $this->buildingStageService->all(),
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
    public function store(StoreBuildingStageRequest $request)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'building_stage_id' => $this->buildingStageService->store($request),
            ],
            'messages' => [__('messages.building_stage.store')]

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

        if ($this->buildingStage->findOrFail($id)) {
            return response()->json([
                'success' => true,
                'data' => [
                    'building_stage' => $this->buildingStageService->show($id),
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
    public function update(UpdateBuildingStageRequest $request, $id)
    {

        if ($this->buildingStage->findOrFail($id)) {
            return response()->json([
                'success' => true,
                'data' => [
                    'building_stage_id' => $this->buildingStageService->update($request, $id),
                ],
                'messages' => [__('messages.building_stage.update')]
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

        if ($this->buildingStage->findOrFail($id)) {
            return response()->json([
                'success' => true,
                'data' => [
                    'building_stage_id' => $this->buildingStageService->destroy($id),
                ],
                'messages' => [__('messages.building_stage.destroy')]
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

        if ($this->buildingStage->withTrashed()->findOrFail($id)) {
            return response()->json([
                'success' => true,
                'data' => [
                    'building_stage_id' => $this->buildingStageService->forceDestroy($id),
                ],
                'messages' => [__('messages.building_stage.force_destroy')]
            ]);
        }
    }
}
