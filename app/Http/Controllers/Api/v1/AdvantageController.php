<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Advantage\IndexAdvantageRequest;
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
}
