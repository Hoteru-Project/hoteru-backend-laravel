<?php

namespace App\Services\V1\FetchIPInfo;

use App\Contracts\V1\FetchIPInfoContract;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

abstract class FetchIPInfo implements FetchIPInfoContract
{
    public final function fetch($ip): array
    {
        try{
            if (filter_var($ip, FILTER_VALIDATE_IP)) {
                $response = Http::accept('application/json')->timeout(2)->get($this->getApiURL($ip));
                return $response->ok() ? $this->reformatResponse($response) : [];
            }
        }catch (Exception $exception){Log::critical($exception->getMessage());}
        return [];
    }
}
