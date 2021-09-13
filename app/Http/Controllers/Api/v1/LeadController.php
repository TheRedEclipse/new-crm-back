<?php

namespace App\Http\Controllers\Api\v1;

use App\Actions\CreateLeadAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\ContactController\CreateRequest;
use App\Http\Requests\Api\v1\ContactController\UpdateRequest;
use App\Http\Requests\Api\v1\FilterRequest;
use App\Http\Requests\Api\v1\GetValuesByModelRequest;
use App\Models\Lead;
use App\Models\Log;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'permission:lead.index'])->only(['index', 'all']);
        $this->middleware(['auth:api', 'permission:lead.edit'])->only(['edit']);
        $this->middleware(['auth:api', 'permission:lead.store'])->only(['store']);
        $this->middleware(['auth:api', 'permission:lead.update'])->only(['update']);
        $this->middleware(['auth:api', 'permission:lead.destroy.soft'])->only(['destroy']);
        $this->middleware(['auth:api', 'permission:lead.show.by_user.own|lead.show.by_user.all'])->only(['showByUserId']);
    }


    /**
     * Постраничный список лидов
     *
     * @return \Illuminate\Http\Response
     */
    public function index(FilterRequest $request)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'leads' => Lead::filters($request)
                            ->with('user')
                            ->with('createdBy')
                            ->with('status')
                            ->paginate($request->per_page ?? 30)
            ]
        ]);
    }


    /**
     * Весь список лидов
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        return response()->json([
            'success' => true,
            'data' => [
                'leads' => Lead::all()
            ]
        ]);
    }


    /**
     * Создание лида
     *
     * @param  CreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        [$lead, $new_user] = CreateLeadAction::run($request);
        $user = auth('api')->user();

        return response()->json([
            'success' => true,
            'message' => ["Lead #{$lead->id} was created"],
            'data' => compact("lead")
        ]);
    }


    /**
     * Получение информации о лиде для редактирования
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'lead' => Lead::whereId($id)->with('user')->with('createdBy')->firstOrFail()
            ]
        ]);
    }

    /**
     * Обновление лида
     *
     * @param  UpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        $lead = Lead::findOrFail($id);
        $lead->update($request->all());
        $lead->addresses()->firstOrFail()->update($request->all());
        
        $user = auth('api')->user();
        Log::createWithRelation([
            'model_type' => $request->model_type ?? Lead::class,
            'model_id' => $request->model_id ?? $lead->id,
            'log_type' => 'LEAD_UPDATE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} updated a lead #{$lead->id}",
            'user_message' => "You updated a lead #{$lead->id}"
        ]);

        return response()->json([
            'success' => true,
            'messages' => ["Lead #{$lead->id} was updated"]
        ]);
    }

    /**
     * Удаление лида
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $lead = Lead::findOrFail($id);
        $address = $lead->addresses()->first();
        if($address) $address->delete();
        $lead->delete();

        $user = auth('api')->user();
        Log::createWithRelation([
            'model_type' => $request->model_type ?? Lead::class,
            'model_id' => $request->model_id ?? $lead->id,
            'log_type' => 'LEAD_DELETE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} deleted a lead #{$lead->id}",
            'user_message' => "You deleted a lead #{$lead->id}"
        ]);

        return response()->json([
            'success' => true,
            'messages' => ["Lead #{$lead->id} was deleted"]
        ]);
    }


    /**
     * Все списки для модели
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getPageByModel(GetValuesByModelRequest $request) {
        if(!class_exists($request->model_type)) throw new \Exception('There is no model type');
        $model = $request->model_type::find($request->id);
        return response()->json([
            'success' => true,
            'data' => [
                'estimates' => $model->estimates ?? [],
                'contacts' => $model->contacts ?? [],
                'notes' => $model->notes ?? [],
                'questions' => $model->questions ?? [],
                'activities' => $model->activities ?? [],
                'emails' => $model->emails ?? [],
                'attachments' => $model->attachments ?? [],
                'tasks' => $model->tasks()->with('createdBy')->with('parent')->with('status')->get() ?? [],
                'requests' => $model->requests()->with('user')->with('createdBy')->with('status')->get() ?? [],
            ]
        ]);
    }

    /**
     * Получение информации о лиде по id пользователя
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showByUserId($id = null) {
        return response()->json([
            'success' => true,
            'data' => [
                'lead' => Lead::whereUserId($id ?? auth('api')->user()->id)->with('user')
                            ->with('createdBy')
                            ->first() ?? (object) []
            ]
        ]);
    }
}
