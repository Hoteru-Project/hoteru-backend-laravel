<?php

namespace App\Http\Controllers\Api\V1\Search;

use App\Services\V1\FormatterService;
use App\Services\V1\SearchService;
use App\Services\V1\FilterService;
use App\Services\V1\SortingService;
use App\Services\V1\UrlParsingService;

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
    protected UrlParsingService $urlParsingService;


    function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
        $this->urlParsingService = new urlParsingService();
    }


    public function index(Request $request) {
        $hotels = $this->searchService->getHotels($request->query());

        if($this->urlParsingService->isServiceRequired('filter')) {
            $hotels = $this->filterHotels($hotels);
        }

        if($this->urlParsingService->isServiceRequired('sorting')) {
            $hotels = $this->sortHotels($hotels);
        }

        return $hotels;
    }

    public function filterHotels ($hotels): array {
        $filteredHotels = new FilterService($hotels);
        $filterParams = $this->urlParsingService->getServiceParams("filter");
        $filteredHotels->filterHotels($filterParams);
        return $filteredHotels->getFilteredHotels();
    }

    public function sortHotels($hotels) {
        $sortingID = $this->urlParsingService->getServiceParams("sorting");
        $sortedHotels = new SortingService($hotels,$sortingID);
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
