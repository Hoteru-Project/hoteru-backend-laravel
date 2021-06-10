<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Requests\Api\V1\Auth\RegisterRequest;
use App\Services\V1\UserService;
use Illuminate\Http\JsonResponse;

class RegisterController extends AuthController
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        parent::__construct();
        $this->userService = $userService;
    }

    public function register(RegisterRequest $registerRequest): JsonResponse
    {
        $user = $this->userService->createUser($registerRequest->validated());
        return response()->json($user, 201);
    }
}
