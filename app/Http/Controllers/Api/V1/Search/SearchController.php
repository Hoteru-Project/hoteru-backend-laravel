<?php

namespace App\Http\Controllers\Api\V1\Search;

use App\Http\Requests\Api\V1\SearchRequest;
use App\Services\V1\FormatterService;
use App\Services\V1\GroupService;
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
    protected GroupService $groupService;
    protected SortingService $sortingService;
    protected array $hotels = array();

    function __construct(SearchService $searchService, GroupService $groupService)
    {
        $this->searchService = $searchService;
        $this->groupService = $groupService;
    }


    public function index(SearchRequest $request) {
        $user = auth("api")->user();
        $data = $request->validated();
        $this->hotels = $this->searchService->getHotels($data);

        $data["search"] = $data["location"];
        $data["type"] = $data["locationType"];

        if($this->hotels){
            $this->searchService->addUserSearch($user, $data);
        }

        if(isset($data["filter"])) {
            $this->hotels = $this->filterHotels($data["filter"],$this->hotels);
        }

        if(isset($data["sorting"])) {
            $this->hotels = $this->sortHotels($data["sorting"],$this->hotels);
        }

        if($request->stars) {
            $this->hotels = $this->filterHotelsByStarsRating($request->stars,$this->hotels);
        }

        if($request->class) {
            $this->hotels = $this->filterHotelsInRange($request->class,$this->hotels);
        }

//        $this->hotels = $this->groupService->getHotelsDistinct($this->hotels);
        return $this->hotels;
    }

    public function getHotelByName(Request $request): array
    {
        return $this->groupService->getHotelsAlike($request->query());
    }

    // based on main amenities
    public function filterHotels ($filterParam,$hotels): array {
        $filteredHotels = new FilterService($hotels);
        $filteredHotels->filterHotels($filterParam);
        return $filteredHotels->getFilteredHotels();
    }

    //  based on stars score
    public function filterHotelsByStarsRating ($stars,$hotels): array {
        $filteredHotels = new FilterService($hotels);
        return $filteredHotels->filterByStars($stars);
    }

    // based on overall ratings in a range
    public function filterHotelsInRange ($class,$hotels): array {
        $filteredHotels = new FilterService($hotels);
        return $filteredHotels->filterInRange($class);
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

}
