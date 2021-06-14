<?php

namespace App\Http\Controllers\Api\V1\Search;

use App\Services\V1\FormatterService;
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
    protected FormatterService $formatterService;

    function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }

    public function index(Request $request)
    {
        $hotels = $this->searchService->getHotels($request->query());
        return $hotels;
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
