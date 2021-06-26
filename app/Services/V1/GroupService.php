<?php


namespace App\Services\V1;


use App\Repositories\V1\ProviderRepository;
use App\Repositories\V1\SearchRepository;

class GroupService extends SearchService
{
    protected array $hotels;

    public function __construct(FormatterService $formatterService, SearchRepository $searchRepository, CurrencyService $currencyService, ProviderRepository $providerRepository)
    {
        parent::__construct($formatterService, $searchRepository, $currencyService, $providerRepository);
    }

    /**
     * @return array
     */
    public function getHotelsDistinct($hotels): array
    {
        $distinct = array();
        $find = array();
        foreach ($hotels as $hotel){
            if(!in_array($hotel->name, $find)){
                $find[] = $hotel->name;
                $distinct[] = $hotel;
            }
        }
        return $distinct;
    }

    public function getHotelsAlike($query): array
    {
        $found = array();
        $user = auth("api")->user();
        $this->hotels = parent::getHotels($user, $query);
        foreach ($this->hotels as $hotel){
            if ($query["name"] == $hotel->name){
                $found[] = $hotel;
            }
        }
        return $found;
    }

}
