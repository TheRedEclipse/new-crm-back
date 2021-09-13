<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\AttachmentController\CreateRequest;
use App\Http\Requests\Api\v1\AttachmentController\UpdateRequest;
use App\Http\Requests\Api\v1\FilterRequest;
use App\Http\Requests\Api\v1\GetValuesByModelRequest;
use App\Models\Attachment;
use App\Models\Status;
use App\Models\Log;
use Illuminate\Http\Request;

class AttachmentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'permission:attachment.index'])->only(['index']);
        $this->middleware(['auth:api', 'permission:attachment.edit'])->only(['edit']);
        $this->middleware(['auth:api', 'permission:attachment.store'])->only(['store']);
        $this->middleware(['auth:api', 'permission:attachment.update'])->only(['update']);
        $this->middleware(['auth:api', 'permission:attachment.destroy.soft'])->only(['destroy']);
    }


    /**
     * Постраничный список прикреплений
     *
     * @return \Illuminate\Http\Response
     */
    public function index(FilterRequest $request)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'attachments' => Attachment::filters($request)
                            ->with('createdBy')
                            ->with('status')
                            ->paginate($request->per_page ?? 30)
            ]
        ]);
    }


    /**
     * Весь список прикреплений
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        return response()->json([
            'success' => true,
            'data' => [
                'attachments' => Attachment::with('createdBy')
                            ->with('status')
                            ->get()
            ]
        ]);
    }


    /**
     * Создание прикрепления
     *
     * @param  CreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $user = auth('api')->user();
        $attachment = Attachment::createWithRelation($request->all() + [
            'status_id' => Status::getIdByTypeAndName('attachment', 'new'),
            'type' => 'image',
            'created_by_id' => $user->id
        ]);
        
        Log::createWithRelation([
            'model_type' => $request->model_type ?? Attachment::class,
            'model_id' => $request->model_id ?? $attachment->id,
            'log_type' => 'ATTACHMENT_CREATE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} created an attachment #{$attachment->id}",
            'user_message' => "You created an attachment #{$attachment->id}"
        ]);
        
        return response()->json([
            'success' => true,
            'messages' => ["Attachment #{$attachment->id} was created"],
        ]);
    }


    /**
     * Получение информации о прикреплении для редактирования
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'attachment' => Attachment::whereId($id)
                                ->with('createdBy')
                                ->with('status')
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
        $attachment = Attachment::findOrFail($id);
        $attachment->update($request->all());
        
        $user = auth('api')->user();
        Log::createWithRelation([
            'model_type' => $request->model_type ?? Attachment::class,
            'model_id' => $request->model_id ?? $attachment->id,
            'log_type' => 'ATTACHMENT_UPDATE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} updated an attachment #{$attachment->id}",
            'user_message' => "You updated an attachment #{$attachment->id}"
        ]);

        return response()->json([
            'success' => true,
            'messages' => ["Attachment #{$attachment->id} was updated"]
        ]);
    }

    /**
     * Удаление прикрепления
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $attachment = Attachment::findOrFail($id);
        $attachment->delete();

        $user = auth('api')->user();
        Log::createWithRelation([
            'model_type' => $request->model_type ?? Attachment::class,
            'model_id' => $request->model_id ?? $attachment->id,
            'log_type' => 'ATTACHMENT_DELETE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} deleted an attachment #{$attachment->id}",
            'user_message' => "You deleted an attachment #{$attachment->id}"
        ]);

        return response()->json([
            'success' => true,
            'messages' => ["Attachment #{$attachment->id} was deleted"]
        ]);
    }

    /**
     * Список прикреплений для модели
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
                'attachments' => $model->attachments ?? []
            ]
        ]);
    }
}
