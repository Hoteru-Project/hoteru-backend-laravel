<?php

namespace App\Repositories\V1;


use App\Contracts\V1\RepositoryContract;

/**
 * Layer to handle datastore operations. Can be a local operation or external datastore
 */
abstract class Repository implements RepositoryContract {
    protected $model;
    public function save($data)
    {
        return $this->model->create($data);
    }
}
