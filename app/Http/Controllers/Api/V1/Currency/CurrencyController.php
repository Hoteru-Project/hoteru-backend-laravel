<?php

namespace App\Http\Controllers\Api\V1\Currency;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Services\V1\CurrencyService;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    private $currencyService;

    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }

    public function index (){
        $currencies = $this->currencyService->listCurrencies();
        return response()->json($currencies,200);
    }

}
