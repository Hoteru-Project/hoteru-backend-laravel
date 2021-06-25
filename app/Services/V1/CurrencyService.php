<?php

namespace App\Services\V1;

use App\Models\Currency;
use App\Repositories\V1\CurrencyRepository;

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
        $this->currencyRepository=$currencyRepository;
    }

    public function listCurrencies(){
        return $this->currencyRepository->showCurrencies();
    }


}
