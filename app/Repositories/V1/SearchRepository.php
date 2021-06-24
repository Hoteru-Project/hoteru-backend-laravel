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

    public function indexOrderBy($orderBy, $orderAsc = true, $limit = -1)
    {
        return $this->model->orderBy($orderBy, $orderAsc ? "ASC" : "DESC")->limit($limit);
    }

    public function getByType($type,  $limit = -1)
    {
        return $this->model->where(["type" => $type])->limit($limit);
    }

    public function getOrderedByType($type, $orderBy, $orderAsc = true, $limit = -1)
    {
        return $this->model->where(["type" => $type])->orderBy($orderBy, $orderAsc ? "ASC" : "DESC")->limit($limit)->get();
    }

    public function getBySearch($search,  $limit = -1)
    {
        return $this->model->where(["search" => $search])->limit($limit);
    }

    public function getOrderedBySearch($search, $orderBy, $orderAsc = true, $limit = -1)
    {
        return $this->getBySearch($search)->orderBy($orderBy, $orderAsc ? "ASC" : "DESC")->limit($limit)->get();
    }

    public function getSearchWith($id, $with, $limit = -1)
    {
        return $this->model->with(
            [
                $with => function ($model) use ($id) {
                    $model->where('id', $id);
                }
            ]
        )->limit($limit);
    }

    public function getOrderedSearchWith($id, $with, $orderBy, $orderAsc = true, $limit = -1)
    {
        return $this->getSearchWith($id, $with)->orderBy($orderBy, $orderAsc ? "ASC" : "DESC")->limit($limit);
    }
    public function getUserSearches($user, $limit=-1)
    {
        return $user->searches()->where("type", "hotel")->orderBy('pivot_created_at', 'DESC')->limit($limit)->get();
    }
}
