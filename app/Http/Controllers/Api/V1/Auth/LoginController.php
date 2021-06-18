<?php

namespace App\Http\Controllers\Api\V1\Auth;

use Illuminate\Http\JsonResponse;

class LoginController extends AuthController
{
    /**
     * Get a JWT via given credentials.
     *
     * @return JsonResponse
     */
    public function login(): JsonResponse
    {
        $credentials = request(['email', 'password']);

        if (! $token = $this->guard()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }
}
