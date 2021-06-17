<?php

namespace App\Http\Controllers\Api\V1\Currency;

use App\Models\Currency;
use App\Services\V1\CurrencyService;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    private $currencyService;

    public function __construct(CurrencyService $currencyService)
    {
        parent::__construct();
        $this->$currencyService = $currencyService;
    }

    public function index (){
        $currencies = Currency::all();
        return response()->json($currencies,201);
    }

    public function store (Request $request){

    }
}
