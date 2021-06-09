<?php


namespace App\Services\V1;


use Illuminate\Support\Facades\Http;
use \Illuminate\Http\Client\Response;

class SearchService
{
    const GOOGLE_KEY = "AIzaSyCjiesSzxUl9zPUjFDi964NGH7WQUmcJUA";
    protected string $query;
    protected string $url;
    protected Response $response;

    function __construct($query)
    {
        $this->setUrl($query);
        $this->response = Http::get($this->url);
    }

    public function getLatitude()
    {
        $latitude = json_decode($this->response)->candidates[0]->geometry->location->lat;
        return $latitude;
    }

    public function getLongitude()
    {
        $longitude = json_decode($this->response)->candidates[0]->geometry->location->lng;
        return $longitude;
    }

    public function getResponse(): Response
    {
        return $this->response;
    }

    private function setUrl($query){
        $this->url = "https://maps.googleapis.com/maps/api/place/findplacefromtext/json?input=".$query."&inputtype=textquery&fields=geometry,name&language=en&key=" . self::GOOGLE_KEY;
    }
}
