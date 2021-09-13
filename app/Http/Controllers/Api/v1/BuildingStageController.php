<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\BuildingStage\IndexBuildingStageRequest;
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

    public function paginate(IndexBuildingStageRequest $request)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'building_stages' => $this->buildingStageService->paginate($request),
            ]
        ]);
    }
}
