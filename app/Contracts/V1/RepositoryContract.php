<?php


namespace App\Contracts\V1;


interface RepositoryContract
{
    /**
     * Save instance in datasource.
     */
    public function save($data);
}
