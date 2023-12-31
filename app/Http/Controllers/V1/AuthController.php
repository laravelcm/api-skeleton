<?php

namespace App\Http\Controllers\V1;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();

        $data['password'] = bcrypt($request->password);

        $user = User::create($data);

        $token = $user->createToken('AUTHTOKEN')->accessToken;

        return response()->json([
            'message' => 'Success',
            'user' => $user,
            'token' => $token,
        ], Response::HTTP_CREATED);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $data = $request->validated();

        if (!Auth::attempt($data)) {
            return response()->json([
                'error' => 'Invalid credentials',
            ], Response::HTTP_UNAUTHORIZED);
        }

        $user = Auth::user();

        $token = $user->createToken('AUTHTOKEN')->accessToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ], Response::HTTP_ACCEPTED);
    }

    public function logoutt(): JsonResponse
    {
        Auth::user()->tokens->each(function ($token, $key) {
            $token->delete();
        });

        return response()->json(['message' => 'logged out successfully'], Response::HTTP_NO_CONTENT);
    }

    public function getUser(): JsonResponse
    {
        $user = Auth::user();

        return response()->json(['user' => $user], Response::HTTP_ACCEPTED);
    }
}
