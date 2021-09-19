<?php

namespace Kolgaev\Users;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Kolgaev\Users\Requests\UserRegistrationRequest;

class Authorization
{

    /**
     * Регистрация нового пользователя
     * 
     * @param \Kolgaev\Users\Requests\UserRegistrationRequest $request
     * @return response
     */
    public static function registration(UserRegistrationRequest $request)
    {

        $user = Users::getUserModel()->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken(Device::getDevice($request))->plainTextToken;

        return response()->json([
            'user' => Authorization::getUserData($user),
            'token' => $token,
        ]);

    }

    /**
     * User authorization and token issuance
     * 
     * @param \Illuminate\Http\Request $request
     * @return response
     */
    public static function login(Request $request)
    {

        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password]))
            return response()->json(['message' => "Неверный логин или пароль"], 400);

        $user = Auth::user();

        $token = $user->createToken(Device::getDevice($request))->plainTextToken;

        return response()->json([
            'user' => Authorization::getUserData($user),
            'token' => $token,
        ]);

    }

    /**
     * Деавторизация пользователя
     * 
     * @param \Illuminate\Http\Request $request
     * @return response
     */
    public static function logout(Request $request)
    {

        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => "Деавторизация произведена",
        ]);

    }

    /**
     * Outputting all user data for initial page load
     * 
     * @param \Illuminate\Http\Request $request
     * @return response
     */
    public static function user(Request $request)
    {

        $user = Authorization::getUserData($request->user());

        return response()->json($user);

    }

    /**
     * User data generation
     * 
     * @param $user
     * @return object
     */
    public static function getUserData($user)
    {

        // Roles user
        $user->roles = $user->roles ?? [];

        // Permissions user
        if (method_exists($user, 'getAllPermissions'))
            $user->permits = $user->getAllPermissions();

        return $user;

    }
    
}