<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Work\IndexWorkRequest;
use App\Models\Work;
use App\Services\WorkService;

class WorkController extends Controller
{

    protected $workService;
    protected $work;

    public function __construct(WorkService $workService, Work $work)
    {

        $this->workService = $workService;
        $this->work = $work;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexWorkRequest $request)
    {

        return response()->json([

            'success' => true,
            'data' => [
            'works' => $this->workService->index($request),
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

        if($this->work->findOrFail($id)) {

            return response()->json([
                'success' => true,
                'data' => [
                    'work' => $this->workService->show($id),
                ]
            ]);

        }

    }
}
