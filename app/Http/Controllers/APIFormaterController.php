<?php

namespace App\Http\Controllers;

use App\Services\V1\FormatterService;

class APIFormaterController extends Controller
{
    protected FormatterService $formaterService;

    function __construct()
    {
        $baseUrl = "http://localhost:8080";
        $providers = ["hotels.com", "booking.com", "trip.com"];
        $params = "checkIn=2021-06-07&checkOut=2021-06-08&lat=-33.8599358&long=151.2090295&rooms=1";
        $this->formaterService = new FormatterService($baseUrl, $providers, $params);
    }

    function index()
    {

        $res = $this->formaterService->getAPI();

        return  $res;
    }
}
