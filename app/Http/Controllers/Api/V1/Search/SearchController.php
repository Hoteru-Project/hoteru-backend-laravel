<?php

namespace App\Http\Controllers\Api\V1\Search;

use App\Services\V1\FormaterService;
use App\Services\V1\SearchService;
use App\Services\V1\FilterService;
use App\Http\Controllers\Controller;
use HttpRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SearchController extends Controller
{
    protected SearchService $searchService;
    protected FormaterService $formatterService;
    private string $long;
    private string $lat;
    private array $providers;
    private string $params;
    private string $baseUrl;

    function __construct()
    {
        $this->baseUrl = env("API_URL");
        $this->providers = explode(',', env("API_PROVIDERS"));
    }

    public function index(): JsonResponse
    {


    }

    public function searchQuery(string $searchQuery)
    {
        $this->searchService = new SearchService($searchQuery);
        $this->lat = $this->searchService->getLatitude();
        $this->long = $this->searchService->getLongitude();
        $response = $this->searchService->getResponse();
        $this->formatterService = new FormaterService($this->baseUrl, $this->providers, "checkIn=2021-06-07&checkOut=2021-06-08&lat=-33.8599358&long=151.2090295&rooms=1");
        $hotels = $this->formatterService->getAPI();
        return $hotels;
    }

//    public function getHotelById($id): JsonResponse
//    {
//        $url = self::URL . '/' . $id;
//        $response = Http::get($url);
//        return response()->json(['hotel' => json_decode($response)]);
//    }

}
