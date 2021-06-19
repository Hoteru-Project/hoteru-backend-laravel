<?php

namespace App\Repositories\V1;


use App\Contracts\V1\RepositoryContract;
use Illuminate\Database\Eloquent\Model;

/**
 * Layer to handle datastore operations. Can be a local operation or external datastore
 */
abstract class Repository implements RepositoryContract
{
    protected Model $model;

    public function getById($id)
    {
        return $this->model->find($id);
    }

    public function update($id, $data)
    {
        $user = $this->getById($id);
        $user->update($data);
        return $user;
    }

    public function save($data)
    {
        return $this->model->create($data);
    }

    public function delete($id)
    {
        return $this->model->find($id)?->delete();
    }
}
