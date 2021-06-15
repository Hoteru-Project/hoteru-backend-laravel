<?php

namespace App\Http\Controllers\Api\V1\Filter;

use App\Http\Controllers\Api\V1\Search\SearchController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\V1\SearchService;
use App\Services\V1\FormatterService;
use App\Services\V1\FilterService;
use App\Http\Controllers\Controller;



class FilterController extends SearchController {

    protected  FilterService $filteredHotels;
    protected  SearchService $searchService;
    protected  array $hotels;


    function __construct() {
        $formatterService = new FormatterService();
        $searchService = new SearchService($formatterService);
        parent::__construct($searchService);
    }

    public function test(Request $request){
        dd($request->query());
    }


    public function filter($filterParams, Request $request) {
//        dd($filterParams, $request->query());
        $this->hotels = parent::index($request);
        $this->filteredHotels = new FilterService($this->hotels);
        $this->filteredHotels->filterHotels($filterParams);
        return array($this->filteredHotels->getFilteredHotels());
    }
}
