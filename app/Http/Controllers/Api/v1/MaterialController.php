<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Material\IndexMaterialRequest;
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
                'materials' => $this->materialService->indexPublic($request),
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
        if ($this->material->findOrFail($id)) {

            return response()->json([
                'success' => true,
                'data' => [
                    'material' => $this->materialService->show($id),
                ]
            ]);
        }
    }
}
