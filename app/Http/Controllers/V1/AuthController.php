<?php

namespace App\Http\Controllers\V1;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;


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

    public function login()
    {

    }
}
