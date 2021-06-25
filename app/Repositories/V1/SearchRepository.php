<?php

namespace App\Repositories\V1;

use App\Models\Search;

/**
 * Layer to handle datastore operations. Can be a local operation or external datastore
 */
class SearchRepository extends Repository
{
    /**
     * Initializing the instances and variables
     *
     * @param Search $search
     */
    public function __construct(Search $search)
    {
        $this->model = $search;
    }

    public function getOrCreateSearch($data): Search
    {
        return $this->model->where("search", $data["search"])->where("type", $data["type"])->first()??$this->save($data);
    }

    public function attachUser($id, $userId){
        $this->getById($id)->users()->attach($userId);
    }

}
