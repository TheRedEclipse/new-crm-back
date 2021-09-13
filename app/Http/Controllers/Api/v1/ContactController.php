<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\ContactController\CreateRequest;
use App\Http\Requests\Api\v1\ContactController\LinkRequest;
use App\Http\Requests\Api\v1\ContactController\UpdateRequest;
use App\Http\Requests\Api\v1\FilterRequest;
use App\Http\Requests\Api\v1\GetValuesByModelRequest;
use App\Models\Contact;
use App\Models\Log;
use App\Models\ModelHasContact;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'permission:contact.index'])->only(['index', 'all']);
        $this->middleware(['auth:api', 'permission:contact.edit'])->only(['edit']);
        $this->middleware(['auth:api', 'permission:contact.store'])->only(['store']);
        $this->middleware(['auth:api', 'permission:contact.update'])->only(['update']);
        $this->middleware(['auth:api', 'permission:contact.destroy.soft'])->only(['destroy']);
    }


    /**
     * Постраничный список контактов
     *
     * @return \Illuminate\Http\Response
     */
    public function index(FilterRequest $request)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'contacts' => Contact::filters($request)->paginate($request->per_page ?? 30)
            ]
        ]);
    }


    /**
     * Весь список контактов
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        return response()->json([
            'success' => true,
            'data' => [
                'contacts' => Contact::all()
            ]
        ]);
    }


    /**
     * Создание контакта
     *
     * @param  CreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $user = auth('api')->user();
        $contact = Contact::createWithAddress($request->all() + [
            'created_by_id' => $user->id
        ]);
        
        Log::createWithRelation([
            'model_type' => 'App\Models\Contact',
            'model_id' => $contact->id,
            'log_type' => 'CONTACT_CREATE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} created a contact #{$contact->id}",
            'user_message' => "You created a contact #{$contact->id}"
        ]);
        
        return response()->json([
            'success' => true,
            'messages' => ["Contact #{$contact->id} was created"]
        ]);
    }


    /**
     * Связывание контакта с моделью
     *
     * @param  CreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function link(LinkRequest $request)
    {
        $user = auth('api')->user();
        ModelHasContact::create($request->all());
        
        Log::createWithRelation([
            'model_type' => $request->model_type,
            'model_id' => $request->model_id,
            'log_type' => 'CONTACT_LINK_TO_MODEL',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} created a link to contact #{$request->contact_id} with model \"{$request->model_type}\" #{$request->model_id}",
            'user_message' => "You created a link to contact #{$request->contact_id}"
        ]);
        
        return response()->json([
            'success' => true,
            'messages' => ["Lnik to contact {$request->contact_id} was created"]
        ]);
    }

    /**
     * Отвязывание контакта от модели
     *
     * @param  CreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function unlink(LinkRequest $request)
    {
        $user = auth('api')->user();
        Contact::find($request->contact_id)->leads()->detach($request->model_id);
        
        Log::createWithRelation([
            'model_type' => $request->model_type,
            'model_id' => $request->model_id,
            'log_type' => 'CONTACT_UNLINK_FROM_MODEL',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} removed a link from contact #{$request->contact_id} with model \"{$request->model_type}\" #{$request->model_id}",
            'user_message' => "You removed a link from contact #{$request->contact_id}"
        ]);
        
        return response()->json([
            'success' => true,
            'messages' => ["Lnik to contact {$request->contact_id} was removed"]
        ]);
    }


    /**
     * Получение информации о контакте для редактирования
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'contact' => Contact::whereId($id)->firstOrFail()
            ]
        ]);
    }

    /**
     * Обновление контакта
     *
     * @param  UpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        $contact = Contact::findOrFail($id);
        $contact->update($request->all());
        $contact->addresses()->firstOrFail()->update($request->all());
        
        $user = auth('api')->user();
        Log::createWithRelation([
            'model_type' => 'App\Models\Contact',
            'model_id' => $contact->id,
            'log_type' => 'CONTACT_UPDATE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} updated a contact #{$contact->id}",
            'user_message' => "You updated a contact #{$contact->id}"
        ]);

        return response()->json([
            'success' => true,
            'messages' => ["Contact #{$contact->id} was updated"]
        ]);
    }

    /**
     * Удаление контакта
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $address = $contact->addresses()->first();
        if($address) $address->delete();
        $contact->delete();

        $user = auth('api')->user();
        Log::createWithRelation([
            'model_type' => 'App\Models\Contact',
            'model_id' => $contact->id,
            'log_type' => 'CONTACT_DELETE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} deleted a contact #{$contact->id}",
            'user_message' => "You deleted a contact #{$contact->id}"
        ]);

        return response()->json([
            'success' => true,
            'messages' => ["Contact #{$contact->id} was deleted"]
        ]);
    }

    /**
     * Список контактов для модели
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
                'contacts' => $model->contacts ?? []
            ]
        ]);
    }
}
