<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\v1\TaskController\CreateRequest;
use App\Http\Requests\Api\v1\TaskController\UpdateRequest;
use App\Http\Requests\Api\v1\FilterRequest;
use App\Http\Requests\Api\v1\GetValuesByModelRequest;
use App\Models\Log;
use App\Models\Task;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'permission:task.index'])->only(['index', 'all']);
        $this->middleware(['auth:api', 'permission:task.edit'])->only(['edit']);
        $this->middleware(['auth:api', 'permission:task.store'])->only(['store']);
        $this->middleware(['auth:api', 'permission:task.update'])->only(['update']);
        $this->middleware(['auth:api', 'permission:task.destroy.soft'])->only(['destroy']);
    }


    /**
     * Постраничный список тасков
     *
     * @return \Illuminate\Http\Response
     */
    public function index(FilterRequest $request)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'tasks' => Task::filters($request)
                            ->with('createdBy')
                            ->with('parent')
                            ->paginate($request->per_page ?? 30)
            ]
        ]);
    }


    /**
     * Весь список тасков
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        return response()->json([
            'success' => true,
            'data' => [
                'tasks' => Task::with('createdBy')
                                ->with('parent')
                                ->get()
            ]
        ]);
    }


    /**
     * Создание таска
     *
     * @param  CreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $user = auth('api')->user();
        $task = Task::createWithRelation($request->all() + [
            'created_by_id' => $user->id
        ]);
        
        Log::createWithRelation([
            'model_type' => $request->model_type ?? Task::class,
            'model_id' => $request->model_id ?? $task->id,
            'log_type' => 'TASK_CREATE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} created a task #{$task->id}",
            'user_message' => "You created a task #{$task->id}"
        ]);
        
        return response()->json([
            'success' => true,
            'messages' => ["Task #{$task->id} was created"],
        ]);
    }


    /**
     * Получение информации о таске для редактирования
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'task' => Task::whereId($id)
                                ->with('parent')
                                ->firstOrFail()
            ]
        ]);
    }

    /**
     * Обновление реквеста
     *
     * @param  UpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        $task = Task::findOrFail($id);
        $task->update($request->all());
        
        $user = auth('api')->user();
        Log::createWithRelation([
            'model_type' => $request->model_type ?? Task::class,
            'model_id' => $request->model_id ?? $task->id,
            'log_type' => 'TASK_UPDATE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} updated a task #{$task->id}",
            'user_message' => "You updated a task #{$task->id}"
        ]);

        return response()->json([
            'success' => true,
            'messages' => ["Task #{$task->id} was updated"]
        ]);
    }

    /**
     * Удаление таска
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        $user = auth('api')->user();
        Log::createWithRelation([
            'model_type' => $request->model_type ?? Task::class,
            'model_id' => $request->model_id ?? $task->id,
            'log_type' => 'TASK_DELETE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} deleted a task #{$task->id}",
            'user_message' => "You deleted a task #{$task->id}"
        ]);

        return response()->json([
            'success' => true,
            'messages' => ["Task #{$task->id} was deleted"]
        ]);
    }

    /**
     * Список тасков для модели
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
                'tasks' => $model->tasks ?? []
            ]
        ]);
    }
}
