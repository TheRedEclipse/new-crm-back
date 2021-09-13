<?php

namespace App\Http\Controllers\Api\v1\Control;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Advantage\IndexAdvantageRequest;
use App\Http\Requests\Api\v1\Advantage\StoreAdvantageRequest;
use App\Http\Requests\Api\v1\Advantage\UpdateAdvantageRequest;
use App\Models\Advantage;
use App\Services\AdvantageService;

class AdvantageController extends Controller
{

    protected $advantageService;
    protected $advantage;

    public function __construct(AdvantageService $advantageService, Advantage $advantage)
    {

        $this->advantageService = $advantageService;
        $this->advantage = $advantage;

        $this->middleware(['auth:api', 'permission:admin.advantage.index'])->only(['index', 'all']);
        $this->middleware(['auth:api', 'permission:admin.advantage.edit'])->only(['edit']);
        $this->middleware(['auth:api', 'permission:admin.advantage.store'])->only(['store']);
        $this->middleware(['auth:api', 'permission:admin.advantage.update'])->only(['update']);
        $this->middleware(['auth:api', 'permission:admin.advantage.destroy.soft'])->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexAdvantageRequest $request)
    {

        return response()->json([

            'success' => true,
            'data' => [
                'advantages' => $this->advantageService->index($request),
            ],

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
                'advantages' => $this->advantage->all(),
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
    public function store(StoreAdvantageRequest $request)
    {

        return response()->json([

            'success' => true,
            'data' => [
                'advantage_id' => $this->advantageService->store($request),
            ],
            'messages' => [__('messages.advantage.store')]

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

        if ($this->advantage->findOrFail($id)) {

            return response()->json([
                'success' => true,
                'data' => [
                    'advantage' => $this->advantageService->show($id),
                ],
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
    public function update(UpdateAdvantageRequest $request, $id)
    {

        if ($this->advantage->findOrFail($id)) {

            return response()->json([
                'success' => true,
                'data' => [
                    'advantage_id' => $this->advantageService->update($request, $id),
                ],
                'messages' => [__('messages.advantage.update')]
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

        if ($this->advantage->findOrFail($id)) {

            return response()->json([
                'success' => true,
                'data' => [
                    'advantage_id' => $this->advantageService->destroy($id),
                ],
                'messages' => [__('messages.advantage.destroy')]
            ]);
        }
    }
}
