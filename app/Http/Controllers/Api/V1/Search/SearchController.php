<?php

namespace App\Http\Controllers\Api\V1\Search;

use App\Services\V1\SearchService;
use App\Http\Controllers\Controller;
use HttpRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SearchController extends Controller
{
    protected SearchService $searchService;

    function __construct()
    {

    }

    public function index(): JsonResponse
    {


    }

    public function searchQuery(string $searchQuery)
    {
        $this->searchService = new SearchService($searchQuery);
        $lat = $this->searchService->getLatitude();
        $long = $this->searchService->getLongitude();
        $response = $this->searchService->getResponse();
//        dd($lat);
//        dd($long);
        return $response;
    }

//    public function getHotelById($id): JsonResponse
//    {
//        $url = self::URL . '/' . $id;
//        $response = Http::get($url);
//        return response()->json(['hotel' => json_decode($response)]);
//    }

}
