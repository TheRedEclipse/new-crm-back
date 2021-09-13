<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Auth\LoginController\LoginRequest;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class LoginController extends Controller
{
    /**
     * Проверка прав для доступа к методам
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Аутентификация паользователя
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $user = User::whereEmail($request->email)->first();
        
        if(!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'messages' => [
                    __('auth.name_does_not_exists')
                ]
            ], 403);
        }

        $token = auth('api')->attempt(
            $request->only([
                'email',
                'password'
            ])
        );

        if (!$token) {
            return response()->json([
                'success' => false,
                'messages' => [
                    __('auth.login_failed')
                ]
            ], 401);
        }

        return $this->respondWithToken($token, boolval($request->remember_me));
    }

    /**
     * Получение данных вошедшего пользователя
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        $user = auth('api')->user();
        $current_user = User::findOrFail($user['id']);
        $roles = $current_user->roles ? $current_user->roles->sortBy('sort')->keyBy('name')->map(function ($value, $key){
            return $value->only(['title', 'style', 'name', 'sort']);
        }) : [];
        return response()->json([
            'success' => true,
            'data' => collect($user)
                        ->put('roles', $roles)
                        ->put('permissions', $current_user->getAllPermissions()
                        ->pluck('title', 'name')),
        ], 200);
    }

    /**
     * Выход пользователя из аккаунта
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();

        return response()->json([
            'success' => true,
            'messages' => [
                __('auth.logged_out')
            ]
        ]);
    }

    /**
     * Обновление токена
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Получение данных пользователя с токеном
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token, $rememner = false)
    {
        $user = auth('api')->user();
        $current_user = User::findOrFail($user['id']);
        $roles = $current_user->roles ? $current_user->roles->sortBy('sort')->keyBy('name')->map(function ($value, $key){
            return $value->only(['title', 'style', 'name', 'sort']);
        }) : [];
        $current_user->update([
            'last_join_ip' => request()->ip()
        ]);
 
        $time = $rememner ? 24*30 : 60;
        return response()->json([
            'success' => true,
            'data' => [
                'access_token' => $token,
                'token_type' => 'bearer',
                'user' => collect($user)
                            ->put('roles', $roles)
                            ->put('permissions', $current_user->getAllPermissions()
                            ->pluck('title', 'name')),
                'expires_in' => auth('api')->factory()->getTTL() * (int) $time
            ]
        ], 200);
    }
}
