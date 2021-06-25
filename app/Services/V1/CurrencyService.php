<?php

namespace App\Services\V1;

use App\Models\Currency;
use App\Repositories\V1\CurrencyRepository;
use App\Services\V1\CurrencyExchange\CurrConvProviderService;

class CurrencyService
{
    /**
     * Variable to hold injected dependency
     *
     * @var CurrencyRepository $currencyRepository
     */
    protected $currencyRepository;

    /**
     * Initializing the instances and variables
     *
     * @param CurrencyRepository $currencyRepository
     */
    public function __construct(CurrencyRepository $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }

    public function listCurrencies()
    {
        return $this->currencyRepository->showCurrencies();
    }

    public function changePrice($hotels, $data)
    {
        if (isset($data["currency"]) && strtoupper(trim($data["currency"])) !== "USD") {
            $data["currency"] = strtoupper(trim($data["currency"]));
            $currencyExchange = (new CurrConvProviderService())->fetch("USD", $data["currency"]);
            if ($currencyExchange) {
                foreach ($hotels as $hotel) {
                    $hotel->hotelPricing->startingAt->plain *= round($currencyExchange["value"], 3);
                    $hotel->hotelPricing->startingAt->formatted = "{$data["currency"]} {$hotel->hotelPricing->startingAt->plain}";

                    foreach ($hotel->rooms as $room) {
                        $room->price *= round($currencyExchange["value"], 3);
                    }
                }
            }
        }
        return $hotels;
    }


}
