<?php

namespace App\Contracts\V1;

use Illuminate\Http\Client\Response;
use JetBrains\PhpStorm\ArrayShape;

interface FetchCurrencyExchangeContract
{
    /**
     * @param string $ip
     * @return array
     */
    public function fetch(string $from, string $to): array;

    /**
     * @param string $ip
     * @return String
     */
    public function getApiURL(string $query): string;

    /**
     * @param Response $response
     * @return array
     */
    #[ArrayShape(["currency_from_to" => "string", "value" => "double"])]
    public function reformatResponse(Response $response): array;
}
