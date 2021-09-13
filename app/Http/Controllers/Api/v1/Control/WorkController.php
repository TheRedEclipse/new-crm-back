<?php

namespace App\Http\Controllers\Api\v1\Control;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Work\IndexWorkRequest;
use App\Http\Requests\Api\v1\Work\StoreWorkRequest;
use App\Http\Requests\Api\v1\Work\UpdateWorkRequest;
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

        $this->middleware(['auth:api', 'permission:admin.work.index'])->only(['index', 'all']);
        $this->middleware(['auth:api', 'permission:admin.work.edit'])->only(['edit']);
        $this->middleware(['auth:api', 'permission:admin.work.store'])->only(['store']);
        $this->middleware(['auth:api', 'permission:admin.work.update'])->only(['update']);
        $this->middleware(['auth:api', 'permission:admin.work.destroy.soft'])->only(['destroy']);

        
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {

        return response()->json([

            'success' => true,
            'data' => [
                'works' => $this->work->all(),
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
    public function store(StoreWorkRequest $request)
    {

        return response()->json([

            'success' => true,
            'data' => [
            'work_id' => $this->workService->store($request),
            ],
            'messages' => [__('messages.work.store')]

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
    public function update(UpdateWorkRequest $request, $id)
    {

        if($this->work->findOrFail($id)) {

            return response()->json([
                'success' => true,
                'data' => [
                'work_id' => $this->workService->update($request, $id),
                ],
                'messages' => [__('messages.work.update')]
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

        if($this->work->findOrFail($id)) {

            return response()->json([
                'success' => true,
                'data' => [
                'work_id' => $this->workService->destroy($id),
                ],
                'messages' => [__('messages.work.destroy')]
            ]);

        }

    }
}
