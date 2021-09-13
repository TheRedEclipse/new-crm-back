<?php

namespace App\Http\Controllers\Api\v1\Reference;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\BuildingType\IndexBuildingTypeRequest;
use App\Http\Requests\Api\v1\BuildingType\StoreBuildingTypeRequest;
use App\Http\Requests\Api\v1\BuildingType\UpdateBuildingTypeRequest;
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

        $this->middleware(['auth:api', 'permission:reference.building_type.index'])->only(['index', 'all']);
        $this->middleware(['auth:api', 'permission:reference.building_type.edit'])->only(['edit']);
        $this->middleware(['auth:api', 'permission:reference.building_type.store'])->only(['store']);
        $this->middleware(['auth:api', 'permission:reference.building_type.update'])->only(['update']);
        $this->middleware(['auth:api', 'permission:reference.building_type.destroy.soft'])->only(['destroy']);
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
    public function all()
    {

        return response()->json([

            'success' => true,
            'data' => [
                'building_types' => $this->buildingTypeService->all(),
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
    public function store(StoreBuildingTypeRequest $request)
    {

        return response()->json([
            'success' => true,
            'data' => [
                'building_type_id' => $this->buildingTypeService->store($request),
            ],
            'messages' => [__('messages.building_type.store')]

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

        if ($this->buildingType->findOrFail($id)) {
            return response()->json([
                'success' => true,
                'data' => [
                    'building_type' => $this->buildingTypeService->show($id),
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
    public function update(UpdateBuildingTypeRequest $request, $id)
    {

        if ($this->buildingType->findOrFail($id)) {
            return response()->json([
                'success' => true,
                'data' => [
                    'building_type_id' => $this->buildingTypeService->update($request, $id),
                ],
                'messages' => [__('messages.building_type.update')]
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

        if ($this->buildingType->findOrFail($id)) {
            return response()->json([
                'success' => true,
                'data' => [
                    'building_type_id' => $this->buildingTypeService->destroy($id),
                ],
                'messages' => [__('messages.building_type.destroy')]
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

        if ($this->buildingType->withTrashed()->findOrFail($id)) {
            return response()->json([
                'success' => true,
                'data' => [
                    'building_type_id' => $this->buildingTypeService->forceDestroy($id),
                ],
                'messages' => [__('messages.building_type.force_destroy')]
            ]);
        }
    }
}
