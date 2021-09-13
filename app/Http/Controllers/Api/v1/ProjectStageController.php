<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\ProjectStage\IndexProjectStageRequest;
use App\Services\ProjectStageService;

class ProjectStageController extends Controller
{

    protected $projectStageService;

    public function __construct(ProjectStageService $projectStageService)
    {
        $this->projectStageService = $projectStageService;
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
    public function paginate(IndexProjectStageRequest $request)
    {
        return response()->json([

            'success' => true,
            'data' => [
                'project_stages' => $this->projectStageService->paginate($request),
            ]

        ]);
    }
}
