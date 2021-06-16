<?php

namespace App\Services\V1;

use App\Models\User;
use App\Repositories\V1\UserRepository;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Password;

class UserService
{
    /**
     * Variable to hold injected dependency
     *
     * @var UserRepository $userRepository
     */
    protected UserRepository $userRepository;

    /**
     * Initializing the instances and variables
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Registering New User
     * @param $data
     * @return User|null
     */
    public function createUser($data): User|null
    {
        $user =  $this->userRepository->save($data);
        event(new Registered($user));
        return $user;
    }

    public function requestResetPasswordToken($data): bool
    {
        $status = Password::sendResetLink(["email" => $data["email"]]);
        return $status === Password::RESET_LINK_SENT;
    }

    public function updateUserPassword($data): bool
    {
        $status = Password::reset(
            [$data["email"], $data["password"], $data["password"], $data["token"]],
            function ($user, $password) {
                $this->userRepository->update($user->id, ["password" => $password]);
            });
        return $status === Password::PASSWORD_RESET;
    }

    public function verify($data): bool
    {
        $user = $this->userRepository->getById($data["id"]);

        if (!hash_equals((string) $data["hash"], sha1($user->getEmailForVerification()))) {
            return false;
        }

        if ($user->markEmailAsVerified())
            event(new Verified($user));
        return true;
    }

    public function resendEmailVerificationNotification($data): bool
    {
        $user = $this->userRepository->getByEmail($data["email"]);
        $user?->sendEmailVerificationNotification();
        return (bool)$user;
    }

}
