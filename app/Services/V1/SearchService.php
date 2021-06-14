<?php


namespace App\Services\V1;


use Illuminate\Support\Facades\Http;
use \Illuminate\Http\Client\Response;

class SearchService
{
    protected string $key;
    protected string $query;
    protected string $url;
    protected Response $response;
    protected Object $decoded_json;
    protected string $apiParams;
    protected string $baseUrl;
    protected array $providers;
    protected string $latitude;
    protected string $longitude;
    protected FormatterService $formatterService;

    function __construct(FormatterService $formatterService)
    {
        $this->formatterService = $formatterService;
        $this->key = env("GOOGLE_KEY");
        $this->providers = explode(',', env("API_PROVIDERS"));
        $this->baseUrl = env("API_URL");
    }

    public function getHotels($query): array
    {
        $explodedQuery = explode('&', $query);
        $location =  explode('=',$explodedQuery[2])[1];
        $this->setUrl($location);
        $this->response = Http::get($this->url);
        $this->decoded_json = json_decode($this->response);
        $this->setLatitude();
        $this->setLongitude();
        $this->setApiParams($explodedQuery[0], $explodedQuery[1],$this->latitude, $this->longitude, $explodedQuery[3]);
        $this->response = Http::get($this->url);
        $this->decoded_json = json_decode($this->response);
        $this->checkResponseStatus($this->decoded_json);
        $this->formatterService->setParams($this->baseUrl, $this->providers, $this->apiParams);
        $hotels["result"] = $this->formatterService->getAPI();
        if(empty($hotels["result"])){
            $hotels["result"] = "no hotels found";
        }
        return $hotels;
    }

    public function setLatitude(): string
    {
        $this->latitude = $this->decoded_json->candidates[0]->geometry->location->lat;
        return $this->latitude;
    }

    public function setLongitude(): string
    {
        $this->longitude = $this->decoded_json->candidates[0]->geometry->location->lng;
        return $this->longitude;
    }

    public function getResponse(): Response
    {
        return $this->response;
    }

    private function setUrl($query)
    {
        $this->url = "https://maps.googleapis.com/maps/api/place/findplacefromtext/json?input=" . $query .
                     "&inputtype=textquery&fields=geometry,name&language=en&key=" . $this->key;
    }

    private function setApiParams($checkIn, $checkOut, $latitude, $longitude, $rooms){
        $this->apiParams = $checkIn."&".$checkOut.
                           "&lat=".$latitude. "&long=".$longitude."&".$rooms;
    }

    private function checkResponseStatus($decoded_json){
        if($decoded_json->status != "OK"){
            dd("no results response from search service");
        }
    }
}
