<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\FilterRequest;
use App\Models\User;

class WorkerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'permission:worker.index'])->only(['index', 'all']);
    }


    /**
     * Постраничный список работников
     *
     * @return \Illuminate\Http\Response
     */
    public function index(FilterRequest $request)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'users' => User::filters($request)
                            ->with('roles')
                            ->whereHas('roles', function($q) {
                                $q->where("name", "worker");
                            })
                            ->paginate($request->per_page ?? 30)
            ]
        ]);
    }


    /**
     * Весь список работников
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        return response()->json([
            'success' => true,
            'data' => [
                'users' => User::with('roles')
                            ->whereHas('roles', function($q) {
                                $q->where("name", "worker");
                            })
                            ->get()
            ]
        ]);
    }

}