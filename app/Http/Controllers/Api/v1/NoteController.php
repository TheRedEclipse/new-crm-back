<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\NoteController\CreateRequest;
use App\Http\Requests\Api\v1\NoteController\UpdateRequest;
use App\Http\Requests\Api\v1\FilterRequest;
use App\Http\Requests\Api\v1\GetValuesByModelRequest;
use App\Models\Log;
use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'permission:note.index'])->only(['index', 'all']);
        $this->middleware(['auth:api', 'permission:note.edit'])->only(['edit']);
        $this->middleware(['auth:api', 'permission:note.store'])->only(['store']);
        $this->middleware(['auth:api', 'permission:note.update'])->only(['update']);
        $this->middleware(['auth:api', 'permission:note.destroy.soft'])->only(['destroy']);
    }


    /**
     * Постраничный список заметок
     *
     * @return \Illuminate\Http\Response
     */
    public function index(FilterRequest $request)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'notes' => Note::filters($request)->paginate($request->per_page ?? 30)
            ]
        ]);
    }


    /**
     * Весь список заметок
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        return response()->json([
            'success' => true,
            'data' => [
                'notes' => Note::all()
            ]
        ]);
    }


    /**
     * Создание заметки
     *
     * @param  CreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $user = auth('api')->user();
        $note = Note::createWithRelation($request->all() + [
            'created_by_id' => $user->id
        ]);
        
        Log::createWithRelation([
            'model_type' => $request->model_type,
            'model_id' => $request->model_id,
            'log_type' => 'NOTE_CREATE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} created a note #{$note->id}",
            'user_message' => "You created a note #{$note->id}"
        ]);
        
        return response()->json([
            'success' => true,
            'messages' => ["Note #{$note->id} was created"]
        ]);
    }


    /**
     * Получение информации о заметке для редактирования
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'note' => Note::whereId($id)->firstOrFail()
            ]
        ]);
    }

    /**
     * Обновление заметки
     *
     * @param  UpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        $note = Note::findOrFail($id);
        $note->update($request->all());
        
        $user = auth('api')->user();
        Log::createWithRelation([
            'model_type' => $request->model_type,
            'model_id' => $request->model_id,
            'log_type' => 'NOTE_UPDATE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} updated a note #{$note->id}",
            'user_message' => "You updated a note #{$note->id}"
        ]);

        return response()->json([
            'success' => true,
            'messages' => ["Note #{$note->id} was updated"]
        ]);
    }

    /**
     * Удаление заметки
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $note = Note::findOrFail($id);
        $note->delete();

        $user = auth('api')->user();
        Log::createWithRelation([
            'model_type' => $request->model_type ?? Note::class,
            'model_id' => $request->model_id ?? $note->id,
            'log_type' => 'NOTE_DELETE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} deleted a note #{$note->id}",
            'user_message' => "You deleted a note #{$note->id}"
        ]);

        return response()->json([
            'success' => true,
            'messages' => ["Note #{$note->id} was deleted"]
        ]);
    }

    /**
     * Список заметок для модели
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
                'notes' => $model->notes ?? []
            ]
        ]);
    }
}
