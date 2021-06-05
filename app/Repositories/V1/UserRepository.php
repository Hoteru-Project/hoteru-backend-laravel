<?php

namespace App\Repositories\V1;

use App\Models\User;

/**
 * Layer to handle datastore operations. Can be a local operation or external datastore
 */
class UserRepository extends Repository
{
    /**
     * Initializing the instances and variables
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }

}
