<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\HotelRequest;
use App\Services\V1\HotelService;
use Illuminate\Http\Request;

class HotelController extends Controller
{

    private HotelService $hotelService;

    public function __construct(HotelService $hotelService)
    {
        $this->hotelService = $hotelService;
    }
    // Get Popular places
    public function popular(HotelRequest $request)
    {
        $response = $this->hotelService->getPopular($request->validated());

        return response()->json($response);
    }
    // get Nearby Places
    public function near(Request $request)
    {

        $response =  $this->hotelService->getNearHotels("156.218.240.39");
        return response()->json($response);
    }
    // get recent visits
    public function recent(Request $request)
    {
        // dd(auth('api')->user());
        $response = $this->hotelService->getRecentHotels(auth('api')->user(), $request->all());
        return response()->json($response);
    }
}
