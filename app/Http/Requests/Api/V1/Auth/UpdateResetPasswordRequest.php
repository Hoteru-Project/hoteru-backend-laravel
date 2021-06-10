<?php

namespace App\Http\Requests\Api\V1\Auth;

use Illuminate\Foundation\Http\FormRequest;

class UpdateResetPasswordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "token" => ["required", "string", "exists:password_resets,token"],
            "email" => ["required", "email", "exists:users,email"],
            "password" => ["required", "string", "min:8"]
        ];
    }
}
