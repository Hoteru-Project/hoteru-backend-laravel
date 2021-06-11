<?php

namespace App\Services\V1;

use GuzzleHttp\Promise;
use GuzzleHttp\Client as GuzzleHttpClient;

class FormaterService
{

    private $baseUrl;
    private $providers;
    private $params;
    private $api_token;


    function __construct($baseUrl, $providers, $params)
    {
        $this->api_token = env("API_TOKEN");
        $this->baseUrl = $baseUrl;
        $this->providers = $providers;
        $this->params = $params;
    }

    function getAPI()
    {
        // getting Data From Different APIs
        $client = new GuzzleHttpClient(['base_uri' => $this->baseUrl]);

        // get all promises requests from providers
        $promises = $this->getPromises($this->providers, $client);

        // Wait Async Request to Respond
        $responses = Promise\Utils::settle($promises)->wait();

        // Accessing body from Responses
        $responsesBodyArr = $this->getResponsesBody($responses);

        // convert strings To Json Arrays & Merge Them into One Array
        $jsonArrays = $this->getJsonArrays($responsesBodyArr);

        return $jsonArrays;
    }

    private function getPromises($providers, $client)
    {
        $i = 1;
        $totalPromises = [];
        foreach ($providers as $provider) {
            $totalPromises["res" . $i] = $client->getAsync("api/" . $provider . "?" . $this->params, ['headers' => ["authorization" => $this->api_token]]);
            $i++;
        }
        return $totalPromises;
    }

    private function getResponsesBody($responses)
    {
        $responsesBody = [];
        $i = $k = 1;
        foreach ($responses as $response) {
            foreach (json_decode($response["value"]->getBody())->data as $hotel){
                $responsesBody["hotel_" . $k] = $hotel;
                $k++;
            }
            $i++;
        }
        return $responsesBody;
    }

    private function getJsonArrays($responses)
    {
        $jsonArrays = array();
        foreach ($responses as $response) {
            array_push($jsonArrays, $response);
        }
        return $jsonArrays;
    }
}
