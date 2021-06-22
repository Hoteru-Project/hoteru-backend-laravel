<?php

namespace App\Contracts\V1;

use Illuminate\Http\Client\Response;
use JetBrains\PhpStorm\ArrayShape;

interface FetchIPInfoContract
{
    /**
     * @param string $ip
     * @return array
     */
    public function fetch(string $ip): array;

    /**
     * @param string $ip
     * @return String
     */
    public function getApiURL(string $ip): string;

    /**
     * @param Response $response
     * @return array
     */
    #[ArrayShape(["country" => "string", "city" => "string", "long" => "string", "lat" => "string", "timezone" => "string"])]
    public function reformatResponse(Response $response): array;
}
