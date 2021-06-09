<?php

namespace App\Services\V1;

use Facade\FlareClient\Http\Client as HttpClient;
use GuzzleHttp\Promise\Promise;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Client as GuzzleHttpClient;

use GuzzleHttp\Psr7\Response;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Promise\Client;
// use Illuminate\Http\Client\Response;

class FormaterService
{
    private $client;
    private $handleResult;
    // private Promise $promise;
    private $data1;
    private $data2;
    private $data3;
    private $allData = array();


    function getAPI()
    {
        // $client = new GuzzleHttpClient();
        // $promise = $client->requestAsync("GET", "http://localhost:3000/hotel");
        // $promise->then(function (Response $response) {
        //     return $response->getBody();
        // })->wait();
        // // $promise->wait();
        // // $promise->then(
        // //     // $onFulfilled
        // //     function ($value) {
        // //         echo 'The promise was fulfilled.';
        // //     },
        // //     // $onRejected
        // //     function ($reason) {
        // //         echo 'The promise was rejected.';
        // //     }
        // // );
        $url = "http://localhost:3000/hotel";
        $this->promise = Http::async()->get($url)->then(
            fn (Response $result) => $this->handleResult = $result
        );
        return $this->promise;
    }


    function getData()
    {
        $res1 = Http::get("http://localhost:3000/hotel");
        $res1 = response()->json(["hotels" => json_decode($res1)]);

        return $res1;
    }








    // function getData()
    // {
    //     $res1 = Http::get("http://localhost:3000/hotel");
    //     $res2 = Http::get("http://localhost:3000/hotel");
    //     $res3 = Http::get("http://localhost:3000/hotel");
    //     $this->data1 = response()->json(["hotels" => json_decode($res1)]);
    //     $this->data2 = response()->json(["hotels" => json_decode($res2)]);
    //     $this->data3 = response()->json(["hotels" => json_decode($res3)]);

    //     return $this->data1;
    // }
}
