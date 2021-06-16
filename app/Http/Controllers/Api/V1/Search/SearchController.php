<?php

namespace App\Http\Controllers\Api\V1\Search;

use App\Services\V1\FormatterService;
use App\Services\V1\SearchService;
use App\Services\V1\FilterService;
use App\Services\V1\SortingService;

use App\Http\Controllers\Controller;
use HttpRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpKernel\Exception\HttpException;


class SearchController extends Controller
{
    protected SearchService $searchService;
    protected FormatterService $formatterService;
    protected FilterService $filterService;
    protected SortingService $sortingService;

    function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }


    public function index(Request $request) {
        $hotels = $this->searchService->getHotels($request->query());

        if($this->searchService->isFilterApplied()) {
            $hotels = $this->filterHotels($hotels);
        }

        if($this->searchService->isSortingApplied()) {
            $hotels = $this->sortHotels($hotels);
        }

        return $hotels;
    }

    public function filterHotels ($hotels) {
        $filteredHotels = new FilterService($hotels);
        $filterParams = $this->searchService->getUrlServices('filter');
        $filteredHotels->filterHotels($filterParams);
        return $filteredHotels->getFilteredHotels();
    }

    public function sortHotels($hotels) {
        $sortingID = $this->searchService->getUrlServices('sorting');
        $sortedHotels = new SortingService($hotels,$sortingID);
        return $sortedHotels->sortSentHotels();
    }

    public function searchQuery(string $searchQuery)
    {
        $hotels = $this->searchService->getHotels($searchQuery);
        return $hotels;
    }

//    public function getHotelById($id): JsonResponse
//    {
//        $url = self::URL . '/' . $id;
//        $response = Http::get($url);
//        return response()->json(['hotel' => json_decode($response)]);
//    }

}
