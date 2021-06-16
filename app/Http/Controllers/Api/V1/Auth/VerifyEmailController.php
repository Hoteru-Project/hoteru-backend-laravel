<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\ResendEmailVerificationRequest;
use App\Services\V1\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VerifyEmailController extends AuthController
{
    private UserService $userService;
    protected $redirectTo;

    public function __construct(UserService $userService)
    {
        parent::__construct();
        $this->userService = $userService;
        $frontEndURL = env("FRONTEND_APP_URL", "http://localhost:3000");
        $this->redirectTo = "$frontEndURL/login?verification=successful";

    }

    public function verify(Request $request): JsonResponse
    {
        $isVerified = $this->userService->verify($request->route()->parameters());
        return response()->json(["success"=> $isVerified], $isVerified?200:400);
    }

    public function send(ResendEmailVerificationRequest $request){
        $response = $this->userService->resendEmailVerificationNotification($request->validated());
        return response()->json(["success"=> $response], $response?200:400);
    }
}
