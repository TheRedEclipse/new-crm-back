<?php

namespace App\Http\Controllers\Api\v1\Control;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Control\PermissionController\CreateRequest;
use App\Http\Requests\Api\v1\Control\PermissionController\UpdateRequest;
use App\Http\Requests\Api\v1\FilterRequest;
use App\Models\Log;

use App\Models\Permission;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'permission:admin.permission.index'])->only(['index']);
        $this->middleware(['auth:api', 'permission:admin.permission.edit'])->only(['edit']);
        $this->middleware(['auth:api', 'permission:admin.permission.store'])->only(['store']);
        $this->middleware(['auth:api', 'permission:admin.permission.update'])->only(['update']);
        $this->middleware(['auth:api', 'permission:admin.permission.destroy.soft'])->only(['destroy']);
    }


    /**
     * Постраничный список прав
     *
     * @return \Illuminate\Http\Response
     */
    public function index(FilterRequest $request)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'permissions' => Permission::filters($request)->paginate($request->per_page ?? 30)
            ]
        ]);
    }


    /**
     * Весь список прав
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        return response()->json([
            'success' => true,
            'data' => [
                'permissions' => Permission::get()
            ]
        ]);
    }


    /**
     * Создание права
     *
     * @param  CreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $permission = Permission::create($request->all());
        
        $user = auth('api')->user();
        Log::createWithRelation([
            'model_type' => 'App\Models\Permission',
            'model_id' => $permission->id,
            'log_type' => 'CONTROL_PERMISSION_CREATE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} created a permission #{$permission->id} (\"{$request->title}\")",
            'user_message' => "You created a permission #{$permission->id}"
        ]);
        
        return response()->json([
            'success' => true,
            'messages' => ["Permission #{$permission->id} was created"]
        ]);
    }


    /**
     * Получение информации о праве для редактирования
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'permission' => Permission::whereId($id)->firstOrFail()
            ]
        ]);
    }

    /**
     * Обновление права
     *
     * @param  UpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        $permission = Permission::findOrFail($id);
        $permission->update($request->all());
        
        $user = auth('api')->user();
        Log::createWithRelation([
            'model_type' => 'App\Models\Permission',
            'model_id' => $permission->id,
            'log_type' => 'CONTROL_PERMISSION_UPDATE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} updated a permission #{$permission->id} (\"{$request->title}\")",
            'user_message' => "You updated a permission #{$permission->id}"
        ]);

        return response()->json([
            'success' => true,
            'messages' => ["Permission #{$permission->id} was updated"]
        ]);
    }

    /**
     * Удаление права
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();

        $user = auth('api')->user();
        Log::createWithRelation([
            'model_type' => 'App\Models\Permission',
            'model_id' => $permission->id,
            'log_type' => 'CONTROL_PERMISSION_DELETE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} deleted a permission #{$permission->id} (\"{$permission->title}\")",
            'user_message' => "You deleted a permission #{$permission->id}"
        ]);

        return response()->json([
            'success' => true,
            'messages' => ["Permission #{$permission->id} was deleted"]
        ]);
    }
}
