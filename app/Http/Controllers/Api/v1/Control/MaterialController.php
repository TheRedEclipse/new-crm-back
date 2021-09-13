<?php

namespace App\Http\Controllers\Api\v1\Control;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Material\IndexMaterialRequest;
use App\Http\Requests\Api\v1\Material\StoreMaterialRequest;
use App\Http\Requests\Api\v1\Material\UpdateMaterialRequest;
use App\Models\Material;
use App\Services\MaterialService;

class MaterialController extends Controller
{

    protected $materialService;
    protected $material;

    public function __construct(MaterialService $materialService, Material $material)
    {
        $this->materialService = $materialService;
        $this->material = $material;

        $this->middleware(['auth:api', 'permission:admin.material.index'])->only(['index', 'all']);
        $this->middleware(['auth:api', 'permission:admin.material.edit'])->only(['edit']);
        $this->middleware(['auth:api', 'permission:admin.material.store'])->only(['store']);
        $this->middleware(['auth:api', 'permission:admin.material.update'])->only(['update']);
        $this->middleware(['auth:api', 'permission:admin.material.destroy.soft'])->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexMaterialRequest $request)
    {
        return response()->json([

            'success' => true,
            'data' => [
                'materials' => $this->materialService->index($request),
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
                'materials' => $this->material->with('photos', 'materialSpecifications')->get(),
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
    public function store(StoreMaterialRequest $request)
    {
        return response()->json([

            'success' => true,
            'data' => [
                'material_id' => $this->materialService->store($request),
            ],
            'messages' => [__('messages.material.store')]

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
        if ($this->material->findOrFail($id)) {

            return response()->json([
                'success' => true,
                'data' => [
                    'material' => $this->materialService->show($id),
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
    public function update(UpdateMaterialRequest $request, $id)
    {
        if ($this->material->findOrFail($id)) {

            return response()->json([
                'success' => true,
                'data' => [
                    'material_id' => $this->materialService->update($request, $id),
                ],
                'messages' => [__('messages.material.update')]
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
        if ($this->material->findOrFail($id)) {

            return response()->json([
                'success' => true,
                'data' => [
                    'material_id' => $this->materialService->destroy($id),
                ],
                'messages' => [__('messages.material.destroy')]
            ]);
        }
    }
}
