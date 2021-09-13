<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\v1\QuestionController\CreateRequest;
use App\Http\Requests\Api\v1\QuestionController\UpdateRequest;
use App\Http\Requests\Api\v1\FilterRequest;
use App\Http\Requests\Api\v1\GetValuesByModelRequest;
use App\Models\Log;
use App\Models\Question;

class QuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'permission:question.index'])->only(['index', 'all']);
        $this->middleware(['auth:api', 'permission:question.edit'])->only(['edit']);
        $this->middleware(['auth:api', 'permission:question.store'])->only(['store']);
        $this->middleware(['auth:api', 'permission:question.update'])->only(['update']);
        $this->middleware(['auth:api', 'permission:question.destroy.soft'])->only(['destroy']);
    }


    /**
     * Постраничный список вопросов
     *
     * @return \Illuminate\Http\Response
     */
    public function index(FilterRequest $request)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'questions' => Question::filters($request)
                                ->with('status')
                                ->with('type')
                                ->with('createdBy')
                                ->paginate($request->per_page ?? 30)
            ]
        ]);
    }


    /**
     * Весь список вопросов
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        return response()->json([
            'success' => true,
            'data' => [
                'questions' => Question::with('createdBy')
                                ->with('status')
                                ->with('type')
                                ->with('createdBy')
                                ->get()
            ]
        ]);
    }


    /**
     * Создание вопроса
     *
     * @param  CreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $user = auth('api')->user();
        $question = Question::createWithRelation($request->all() + [
            'created_by_id' => $user->id
        ]);
        
        Log::createWithRelation([
            'model_type' => $request->model_type ?? Question::class,
            'model_id' => $request->model_id ?? $question->id,
            'log_type' => 'QUESTION_CREATE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} created a question #{$question->id}",
            'user_message' => "You created a question #{$question->id}"
        ]);
        
        return response()->json([
            'success' => true,
            'messages' => ["Question #{$question->id} was created"],
        ]);
    }


    /**
     * Получение информации о вопросе для редактирования
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'question' => Question::whereId($id)
                                ->with('status')
                                ->with('type')
                                ->with('createdBy')
                                ->firstOrFail()
            ]
        ]);
    }

    /**
     * Обновление вопроса
     *
     * @param  UpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        $question = Question::findOrFail($id);
        $question->update($request->all());
        
        $user = auth('api')->user();
        Log::createWithRelation([
            'model_type' => $request->model_type ?? Question::class,
            'model_id' => $request->model_id ?? $question->id,
            'log_type' => 'QUESTION_UPDATE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} updated a question #{$question->id}",
            'user_message' => "You updated a question #{$question->id}"
        ]);

        return response()->json([
            'success' => true,
            'messages' => ["Question #{$question->id} was updated"]
        ]);
    }

    /**
     * Удаление вопроса
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $question = Question::findOrFail($id);
        $question->delete();

        $user = auth('api')->user();
        Log::createWithRelation([
            'model_type' => $request->model_type ?? Question::class,
            'model_id' => $request->model_id ?? $question->id,
            'log_type' => 'QUESTION_DELETE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} deleted a question #{$question->id}",
            'user_message' => "You deleted a question #{$question->id}"
        ]);

        return response()->json([
            'success' => true,
            'messages' => ["Question #{$question->id} was deleted"]
        ]);
    }

    /**
     * Список вопросов для модели
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
                'questions' => $model->questions()->with('createdBy')->with('status')->with('type')->get() ?? []
            ]
        ]);
    }
}
