<?php

namespace App\Http\Controllers\Api\v1\Control;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Control\RoleController\CreateRequest;
use App\Http\Requests\Api\v1\Control\RoleController\UpdateRequest;
use App\Http\Requests\Api\v1\FilterRequest;
use App\Models\Role;
use App\Models\Log;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'permission:admin.role.index'])->only(['index', 'all']);
        $this->middleware(['auth:api', 'permission:admin.role.edit'])->only(['edit']);
        $this->middleware(['auth:api', 'permission:admin.role.store'])->only(['store']);
        $this->middleware(['auth:api', 'permission:admin.role.update'])->only(['update']);
        $this->middleware(['auth:api', 'permission:admin.role.destroy.soft'])->only(['destroy']);
    }

    /**
     * Постраничный список ролей
     *
     * @return \Illuminate\Http\Response
     */
     public function index(FilterRequest $request)
     {
        return response()->json([
            'success' => true,
            'data' => [
                'roles' => Role::filters($request)->with('permissions')->paginate($request->per_page ?? 30),
            ]
        ]);
     }


     /**
     * Весь список ролей
     *
     * @return \Illuminate\Http\Response
     */
     public function all()
     {
        return response()->json([
            'success' => true,
            'data' => [
                'roles' => Role::get()
            ]
        ]);
     }

 
     /**
      * Создание роли
      *
      * @param  \Illuminate\Http\Request  $request
      * @return \Illuminate\Http\Response
      */
     public function store(CreateRequest $request)
     {
         $role = Role::create($request->all() + ['guard_name' => 'api']);
         $role->givePermissionTo($request->permissions ?? []);
         
         $user = auth('api')->user();
         Log::createWithRelation([
            'model_type' => 'App\Models\Role',
            'model_id' => $role->id,
            'log_type' => 'CONTROL_ROLE_CREATE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} created a role #{$role->id} (\"{$role->title}\")",
            'user_message' => "You created a role #{$role->id}"
         ]);
         
         return response()->json([
            'success' => true,
            'messages' => ["Role #{$role->id} was created"]
         ]);
     }

 
     /**
      * Получение информации о роли для редактирования
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function show(int $id)
     {
        return response()->json([
            'success' => true,
            'data' => [
            'role' => Role::whereId($id)->firstOrFail(),
            'permissions' => Role::whereId($id)->first()->permissions
            ]
        ]);
     }
 
     /**
      * Обновление роли
      *
      * @param  \Illuminate\Http\Request  $request
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function update(UpdateRequest $request, $id)
     {
        $role = Role::findOrFail($id);
        $role->update($request->all());
        $role->syncPermissions($request->permissions ?? []);

        $user = auth('api')->user();
        Log::createWithRelation([
            'model_type' => 'App\Models\Role',
            'model_id' => $role->id,
            'log_type' => 'CONTROL_ROLE_UPDATE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} updated a role #{$role->id} (\"{$request->title}\")",
            'user_message' => "You updated a role #{$role->id}"
        ]);

        return response()->json([
            'success' => true,
            'messages' => ["Role #{$role->id} was updated"]
        ]);
     }
 
     /**
      * Удаление роли
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function destroy($id)
     {
        $role = Role::findOrFail($id);
        $role->syncPermissions([]);
        $role->delete();

        $user = auth('api')->user();
        Log::createWithRelation([
            'model_type' => 'App\Models\Role',
            'model_id' => $role->id,
            'log_type' => 'CONTROL_ROLE_DELETE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} deleted a role #{$role->id} (\"{$role->title}\")",
            'user_message' => "You deleted a role #{$role->id}"
        ]);

        return response()->json([
            'success' => true,
            'messages' => ["Role #{$role->id} was deleted"]
        ]);
     }
}
