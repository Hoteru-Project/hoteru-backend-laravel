<?php


namespace App\Contracts\V1;


interface RepositoryContract
{

    /**
     * Get instance in datasource by id.
     * @param $id numeric
     */
    public function getById($id);

    /**
     * Update instance in datasource.
     * @param $data
     * @param $id numeric
     */
    public function update($id, $data);

    /**
     * Save instance in datasource.
     * @param $data
     */
    public function save($data);

    /**
     * Delete instance from datasource by id.
     * @param $id numeric
     */
    public function delete($id);
}
