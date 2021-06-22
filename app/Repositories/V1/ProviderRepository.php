<?php

namespace App\Repositories\V1;

use App\Models\Provider;

/**
 * Layer to handle datastore operations. Can be a local operation or external datastore
 */
class ProviderRepository extends Repository
{
    /**
     * Initializing the instances and variables
     *
     * @param Provider $provider
     */
    public function __construct(Provider $provider)
    {
        $this->model = $provider;
    }

}
