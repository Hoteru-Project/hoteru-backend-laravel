<?php

namespace App\Services\V1;

use App\Repositories\V1\UserRepository;

class UserService
{
    /**
     * Variable to hold injected dependency
     *
     * @var UserRepository $userRepository
     */
    protected $userRepository;

    /**
     * Initializing the instances and variables
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository=$userRepository;
    }

    public function createUser($data){
        return $this->userRepository->save($data);
    }
}
