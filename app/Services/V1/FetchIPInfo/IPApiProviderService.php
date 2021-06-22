<?php


namespace App\Services\V1\FetchIPInfo;

use Illuminate\Http\Client\Response;
use JetBrains\PhpStorm\ArrayShape;

class IPApiProviderService extends FetchIPInfo
{
    /**
     * @param string $ip
     * @return string
     */
    public function getApiURL(string $ip): string
    {
        return "http://ip-api.com/json/{$ip}";
    }

    /**
     * @param Response $response
     * @return array
     */
    #[ArrayShape(["country" => "mixed", "city" => "mixed", "lat" => "mixed", "long" => "mixed", "timezone" => "mixed"])]
    public function reformatResponse(Response $response): array
    {
        return [
            "country" => $response["countryCode"],
            "city" => $response["city"],
            "lat" => (string)$response["lat"],
            "long" => (string)$response["lon"],
            "timezone" => $response["timezone"]
        ];
    }
}
