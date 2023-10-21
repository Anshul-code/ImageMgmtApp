<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Register User
     *
     * @param \App\Http\Requests\RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();

        $user = User::create($data);

        $token = $user->createToken('authtoken')->plainTextToken;

        $user = $user->load('role');

        return response()->json([
            'success' => true,
            'token'   => $token,
            'user'    => $user,
            'message' => __('User registered.')
        ]);
    }

    /**
     * Login User
     *
     * @param \App\Http\Requests\LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $user = User::with('role')->where('email', $request->email)->first();

        if ($user == null || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => __('These credentials do not match our records.')
            ]);
        }

        $token = $user->createToken('authtoken')->plainTextToken;

        return response()->json([
            'success' => true,
            'token'   => $token,
            'user'    => $user,
            'message' => __('Log in successfull')
        ]);
    }

    /**
     * Get Authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkUser(): JsonResponse
    {
        $user = auth('sanctum')->user();

        if(!$user) {
            return response()->json([
                'success' => false,
                'data'    => null,
                'message' => 'User not found.'
            ]);
        }
        
        $user = $user->load('role');

        return response()->json([
            'success' => true,
            'data'    => $user,
            'message' => 'User found.'
        ]);
    }

    /**
     * Get All Roles
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRoles() : JsonResponse
    {
        $roles = Role::all();

        return response()->json([
            'success' => true,
            'data'    => $roles,
            'message' => 'Data found.'
        ]);
    }

    /**
     * Delete tokens and logout
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request) : JsonResponse
    {
        $user = auth('sanctum')->user();

        if($user) {
            $user->currentAccessToken()->delete();
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Logged Out.'
        ]);
    }
}
