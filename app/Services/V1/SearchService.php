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
    protected mixed $decoded_json;

    function __construct($query)
    {
        $this->key = env("GOOGLE_KEY");
        $this->setUrl($query);
        $this->response = Http::get($this->url);
        $this->decoded_json = json_decode($this->response);
        $this->checkResponseStatus($this->decoded_json->status);

    }

    public function getLatitude()
    {
        $latitude = $this->decoded_json->candidates[0]->geometry->location->lat;
        return $latitude;
    }

    public function getLongitude()
    {
        $longitude = $this->decoded_json->candidates[0]->geometry->location->lng;
        return $longitude;
    }

    public function getResponse(): Response
    {
        return $this->response;
    }

    private function setUrl($query)
    {
        $this->url = "https://maps.googleapis.com/maps/api/place/findplacefromtext/json?input=" . $query . "&inputtype=textquery&fields=geometry,name&language=en&key=" . $this->key;
    }
    private function checkResponseStatus($decoded_json){
        if($this->decoded_json->status == "ZERO_RESULTS"){
            dd("no results response from search service");
//            dd($this->decoded_json);
        }
    }
}
