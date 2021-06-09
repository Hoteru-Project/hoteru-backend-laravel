<?php

namespace App\Http\Controllers;

use Facade\FlareClient\Http\Client as HttpClient;
use GuzzleHttp\Promise\Promise;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Psr7\Response;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Services\V1\FormaterService;
use Illuminate\Http\JsonResponse;

class APIFormaterController extends Controller
{
    protected FormaterService $formaterService;

    function __construct(FormaterService $formaterService)
    {
        $this->formaterService = $formaterService;
    }

    function index()
    {
        $client = new GuzzleHttpClient();
        $promise = $client->requestAsync("GET", "http://localhost:3000/hotel");
        $promise->then(function (JsonResponse $response) {
            return json_decode($response->getBody());
        });
        $x = $promise->wait();
        // $res = $this->formaterService->getAPI();
        // // dd("cont");
        // // dd($res);
        dd($x);
    }
}
