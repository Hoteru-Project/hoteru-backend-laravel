<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\RequestResetPasswordRequest;
use App\Http\Requests\Api\V1\Auth\UpdateResetPasswordRequest;
use App\Services\V1\UserService;
use Illuminate\Support\Facades\Log;

class ResetPasswordController extends AuthController
{

    private UserService $userService;

    public function __construct(UserService $userService)
    {
        parent::__construct();
        $this->userService = $userService;
    }

    public function email(RequestResetPasswordRequest $request)
    {
        $response = $this->userService->requestResetPasswordToken($request->validated());
        return response()->json(["success"=> $response], $response?200:400);
    }

    public function update(UpdateResetPasswordRequest $request)
    {
        $response = $this->userService->updateUserPassword($request->only('email', 'password', 'password_confirmation', 'token'));
        return response()->json(["success"=> $response], $response?200:400);
    }
}
