<?php

namespace App\Http\Controllers\Api\V1\Auth;

use Illuminate\Http\JsonResponse;

class RefreshTokenController extends AuthController
{
    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
        return $this->respondWithToken($this->guard()->refresh());
    }
}
