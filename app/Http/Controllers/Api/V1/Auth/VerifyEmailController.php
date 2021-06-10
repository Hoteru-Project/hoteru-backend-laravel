<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\ResendEmailVerificationRequest;
use App\Services\V1\UserService;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class VerifyEmailController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function verify(EmailVerificationRequest $request){
        $request->fulfill();
    }

    public function send(ResendEmailVerificationRequest $request){
        $this->userService->resendEmailVerificationNotification($request->validated());
    }
}
