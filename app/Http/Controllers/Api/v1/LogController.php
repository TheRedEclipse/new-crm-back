<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\FilterRequest;
use App\Http\Requests\Api\v1\GetValuesByModelRequest;
use App\Models\Log;

class LogController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'permission:log.index'])->only(['index', 'all']);
        $this->middleware(['auth:api', 'permission:log.edit'])->only(['edit']);
        $this->middleware(['auth:api', 'permission:log.store'])->only(['store']);
        $this->middleware(['auth:api', 'permission:log.update'])->only(['update']);
        $this->middleware(['auth:api', 'permission:log.destroy.soft'])->only(['destroy']);
    }


    /**
     * Постраничный список логов
     *
     * @return \Illuminate\Http\Response
     */
    public function index(FilterRequest $request)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'activities' => Log::filters($request)
                                ->with('fromUser')
                                ->with('toUser')
                                ->with('type')
                                ->paginate($request->per_page ?? 30)
            ]
        ]);
    }


    /**
     * Весь список логов
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        return response()->json([
            'success' => true,
            'data' => [
                'activities' => Log::with('fromUser')
                                ->with('toUser')
                                ->with('type')
                                ->get()
            ]
        ]);
    }

    /**
     * Получение информации о логе для редактирования
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'activity' => Log::whereId($id)
                                ->with('fromUser')
                                ->with('toUser')
                                ->with('type')
                                ->firstOrFail()
            ]
        ]);
    }

    /**
     * Список логов для модели
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getValuesByModel(GetValuesByModelRequest $request) {
        if(!class_exists($request->model_type)) throw new \Exception('There is no model type');
        $model = $request->model_type::find($request->id);
        return response()->json([
            'success' => true,
            'data' => [
                'activities' => $model->logs ?? []
            ]
        ]);
    }
}
