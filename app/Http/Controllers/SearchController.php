<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SearchController extends Controller
{
    const URL = "http://localhost:3000/hotels";

    public function index()
    {
        $response = Http::get(self::URL);
        return json_decode($response);
    }
    public function getHotelById($id): JsonResponse
    {
        $url = self::URL .'/' . $id;
        $response = Http::get($url);
        return response()->json(['hotel' => json_decode($response)]);
    }

}
