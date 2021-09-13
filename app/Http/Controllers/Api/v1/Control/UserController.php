<?php

namespace App\Http\Controllers\Api\v1\Control;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Control\UserController\CreateRequest;
use App\Http\Requests\Api\v1\Control\UserController\UpdateRequest;
use App\Http\Requests\Api\v1\FilterRequest;
use App\Models\Log;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'permission:admin.user.index'])->only(['index']);
        $this->middleware(['auth:api', 'permission:admin.user.edit'])->only(['edit']);
        $this->middleware(['auth:api', 'permission:admin.user.store'])->only(['store']);
        $this->middleware(['auth:api', 'permission:admin.user.update'])->only(['update']);
        $this->middleware(['auth:api', 'permission:admin.user.destroy.soft'])->only(['destroy']);
    }


    /**
     * Постраничный список пользователей
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
                            ->paginate($request->per_page ?? 30)
            ]
        ]);
    }


    /**
     * Весь список пользователей
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        return response()->json([
            'success' => true,
            'data' => [
                'users' => User::with('roles')
                            ->get()
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
        $current_user = User::create($request->all());
        $current_user->syncRoles($request->roles ?? []);
        
        $user = auth('api')->user();
        Log::createWithRelation([
            'model_type' => 'App\Models\User',
            'model_id' => $user->id,
            'log_type' => 'CONTROL_USER_CREATE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} created a user #{$current_user->id} ({$request->name} {$request->last_name})",
            'user_message' => "You created a user #{$current_user->id}"
        ]);
        
        return response()->json([
            'success' => true,
            'messages' => ["User #{$current_user->id} was created"]
        ]);
    }


    /**
     * Получение информации о пользователе для редактирования
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'user' => User::whereId($id)->firstOrFail()
            ]
        ]);
    }

    /**
     * Обновление пользователя
     *
     * @param  UpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        $current_user = User::findOrFail($id);
        $current_user->update($request->all());
        $current_user->syncRoles($request->roles ?? []);
        
        $user = auth('api')->user();
        Log::createWithRelation([
            'model_type' => 'App\Models\User',
            'model_id' => $current_user->id,
            'log_type' => 'CONTROL_USER_UPDATE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} updated a user #{$current_user->id} ({$request->name} {$request->last_name})",
            'user_message' => "You updated a user #{$current_user->id}"
        ]);

        return response()->json([
            'success' => true,
            'messages' => ["User #{$current_user->id} was updated"]
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
        $current_user = User::findOrFail($id);
        $current_user->delete();

        $user = auth('api')->user();
        Log::createWithRelation([
            'model_type' => 'App\Models\User',
            'model_id' => $current_user->id,
            'log_type' => 'CONTROL_USER_DELETE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} deleted a user #{$current_user->id} ({$current_user->name} {$current_user->last_name})",
            'user_message' => "You deleted a user #{$current_user->id}"
        ]);

        return response()->json([
            'success' => true,
            'messages' => ["User #{$current_user->id} was deleted"]
        ]);
    }
}
