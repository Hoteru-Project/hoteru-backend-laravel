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
    public function getHotelById($id)
    {
         $url = self::URL .'/' . $id;
//        dd($url);
        $response = Http::get($url);
//        dd(json_decode($response));
        return json_decode($response);
//        return $response;
    }


    public function fetch()
    {
        $response = Http::get('http://localhost:3000/hotels');
        return json_decode($response->body());
    }

}
