<?php


namespace App\Services\V1;


use Illuminate\Support\Facades\Http;
use \Illuminate\Http\Client\Response;

class SearchService
{
    protected string $key;
    protected string $url;
    protected string $baseUrl;
    protected array $providers;
    protected FormatterService $formatterService;
    private Object $decoded_json;
    private string $apiParams;

    function __construct(FormatterService $formatterService)
    {
        $this->formatterService = $formatterService;
        $this->key = env("GOOGLE_KEY");
        $this->providers = explode(',', env("API_PROVIDERS"));
        $this->baseUrl = env("API_URL");
    }

    public function getHotels($query): array
    {
        $this->setUrl($query["location"]);
        $this->decoded_json = json_decode(Http::get($this->url));
        $this->setApiParams($query["checkIn"], $query["checkOut"],
                            $this->getLatitude(), $this->getLongitude(), $query["rooms"]);

        $this->formatterService->setParams($this->baseUrl, $this->providers, $this->apiParams);
        $hotels["result"] = $this->formatterService->getAPI();
//        if (empty($hotels["result"])) {
//            $hotels["result"] = "no hotels found";
//        }
        return $hotels;
    }

    public function getLatitude(): string
    {
        return $this->decoded_json->candidates[0]->geometry->location->lat;
    }

    public function getLongitude(): string
    {
        return $this->decoded_json->candidates[0]->geometry->location->lng;
    }

    private function setUrl($location)
    {
        $this->url = "https://maps.googleapis.com/maps/api/place/findplacefromtext/json?input=" . $location .
            "&inputtype=textquery&fields=geometry,name&language=en&key=" . $this->key;
    }

    private function setApiParams($checkIn, $checkOut, $latitude, $longitude, $rooms)
    {
        $this->apiParams = "checkIn=" . $checkIn . "&checkOut=" . $checkOut .
            "&lat=" . $latitude . "&long=" . $longitude . "&rooms=" . $rooms;
    }

    public function getApiParams() {
        return $this->apiParams;
    }

    public function getFilterParams() {
        $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $queryStr = parse_url($url, PHP_URL_QUERY);
        parse_str($queryStr, $queryParams);
        array_key_exists('filter',$queryParams) ? $searchParams = $queryParams['filter'] : $searchParams = "";
        return $searchParams;
    }

    public function isFilterApplied(){
        return !empty($this->getFilterParams());
    }


    private function checkResponseStatus($decoded_json)
    {
        if ($decoded_json->status != "OK") {
            dd("no results response from search service");
        }
    }
}
