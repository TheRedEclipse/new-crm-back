<?php

namespace App\Http\Controllers\Api\v1\Reference;

use App\Http\Controllers\Controller;
use App\Models\State;
use App\Services\Reference\StateService;
use Illuminate\Http\Request;

class StateController extends Controller
{
    protected $stateService;
    protected $state;

    public function __construct(StateService $stateService, State $state)
    {
        $this->stateService = $stateService;
        $this->state = $state;
    }

    public function index(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'states' => $this->stateService->index($request),
            ],
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
