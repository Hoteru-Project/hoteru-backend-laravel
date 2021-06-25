<?php

namespace App\Services\V1\CurrencyExchange;

use App\Contracts\V1\FetchCurrencyExchangeContract;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

abstract class FetchFetchCurrencyExchange implements FetchCurrencyExchangeContract
{
    public final function fetch($from, $to): array
    {
        try{
            $query = strtoupper("{$from}_{$to}");
            $response = Http::accept('application/json')->timeout(2)->get($this->getApiURL($query));
            return $response->ok() ? $this->reformatResponse($response) : [];
        }catch (Exception $exception){Log::critical($exception->getMessage());}
        return [];
    }
}
