<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\BuildingType\IndexBuildingTypeRequest;
use App\Models\BuildingType;
use App\Services\BuildingTypeService;

class BuildingTypeController extends Controller
{

    protected $buildingTypeService;
    protected $buildingType;

    public function __construct(BuildingTypeService $buildingTypeService, BuildingType $buildingType)
    {
        $this->buildingTypeService = $buildingTypeService;
        $this->buildingType = $buildingType;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexBuildingTypeRequest $request)
    {
        return response()->json([

            'success' => true,
            'data' => [
                'building_types' => $this->buildingTypeService->index($request),
            ]

        ]);
    }

        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function paginate(IndexBuildingTypeRequest $request)
    {
        return response()->json([

            'success' => true,
            'data' => [
                'building_types' => $this->buildingTypeService->paginate($request),
            ]

        ]);
    }
}
