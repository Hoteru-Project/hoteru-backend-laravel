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

        if($request->filter) {
            $hotels = $this->filterHotels($request->filter,$hotels);
        }

        if($request->sorting) {
            $hotels = $this->sortHotels($request->sorting,$hotels);
        }

        return $hotels;
    }

    public function filterHotels ($filterParam,$hotels): array {
        $filteredHotels = new FilterService($hotels);
        $filteredHotels->filterHotels($filterParam);
        return $filteredHotels->getFilteredHotels();
    }

    public function sortHotels($sortID,$hotels) {
        $sortedHotels = new SortingService($hotels,$sortID);
        return $sortedHotels->sortSentHotels();
    }

    public function searchQuery(string $searchQuery)
    {
        $hotels = $this->searchService->getHotels($searchQuery);
        return $hotels;
    }
    // example url 127.0.0.1:8001/api/v1/hotels/test?checkIn=2021-06-07&checkOut=2021-06-08&location=alexandria&rooms=1&sorting=2&filter=pool


//    public function getHotelById($id): JsonResponse
//    {
//        $url = self::URL . '/' . $id;
//        $response = Http::get($url);
//        return response()->json(['hotel' => json_decode($response)]);
//    }

}
