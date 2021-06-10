<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\RequestResetPasswordRequest;
use App\Http\Requests\Api\V1\Auth\UpdateResetPasswordRequest;
use App\Services\V1\UserService;

class ResetPasswordController extends Controller
{

    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function email(RequestResetPasswordRequest $request)
    {
        $this->userService->requestResetPasswordToken($request->validated());
    }

    public function update(UpdateResetPasswordRequest $request)
    {
        $this->userService->updateUserPassword($request->validated());
    }
}
