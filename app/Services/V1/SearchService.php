<?php


namespace App\Services\V1;


use App\Repositories\V1\SearchRepository;
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
    private CurrencyService $currencyService;
    private SearchRepository $searchRepository;

    function __construct(FormatterService $formatterService, SearchRepository $searchRepository, CurrencyService $currencyService)
    {
        $this->formatterService = $formatterService;
        $this->searchRepository = $searchRepository;
        $this->currencyService = $currencyService;
        $this->key = env("GOOGLE_KEY");
        $this->providers = explode(',', env("API_PROVIDERS"));
        $this->baseUrl = env("API_URL");
    }

    public function getHotels($user, $data): array
    {
        $this->setUrl($data["location"]);
        $this->decoded_json = json_decode(Http::get($this->url));
        $this->setApiParams($data["checkIn"], $data["checkOut"],
                            $this->getLatitude(), $this->getLongitude(), $data["rooms"]);

        $this->formatterService->setParams($this->baseUrl, $this->providers, $this->apiParams);
        $hotels =  $this->formatterService->getAPI();

        if($hotels){
            $this->addUserSearch($user, $data);
            $hotels = $this->currencyService->changePrice($hotels, $data);

        }
        return $hotels;
    }

    public function getLatitude(): string
    {
        return $this->decoded_json->candidates[0]->geometry->location->lat??"";
    }

    public function getLongitude(): string
    {
        return $this->decoded_json->candidates[0]->geometry->location->lng??"";
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

    private function checkResponseStatus($decoded_json)
    {
        if ($decoded_json->status != "OK") {
            dd("no results response from search service");
        }
    }

    public function addUserSearch($user, $data){
        $search =  $this->searchRepository->getOrCreateSearch($data);
        $search->count++;
        $this->searchRepository->update($search->id, $search->toArray());
        if($user){
            $this->searchRepository->attachUser($search->id, $user->id);
        }
        return ["success" => true];
    }
}
