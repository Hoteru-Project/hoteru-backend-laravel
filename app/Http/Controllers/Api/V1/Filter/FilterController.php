<?php

namespace App\Http\Controllers\Api\V1\Filter;

use App\Http\Controllers\Api\V1\Search\SearchController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\V1\SearchService;
use App\Services\V1\FilterService;
use App\Http\Controllers\Controller;



class FilterController extends SearchController {

    protected  FilterService $filteredHotels;
    protected  array $hotels;


    function __construct() {
        parent::__construct();
    }

    public function filter($cityName,$filterParams) {
        $this->hotels = parent::searchQuery($cityName);
        $this->filteredHotels = new FilterService($this->hotels,$cityName);
        $this->filteredHotels->filterHotels($filterParams);
        return array($this->filteredHotels->getFilteredHotels());
    }
}
