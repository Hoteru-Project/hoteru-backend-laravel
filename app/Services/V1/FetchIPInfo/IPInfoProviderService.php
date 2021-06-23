<?php


namespace App\Services\V1\FetchIPInfo;

use Illuminate\Http\Client\Response;
use JetBrains\PhpStorm\ArrayShape;

class IPInfoProviderService extends FetchIPInfo
{
    /**
     * @var string|mixed
     */
    private string $token;

    /**
     * IPInfoProviderService constructor.
     */
    public function __construct()
    {
        $this->token = ENV("IPINFO_PROVIDER_TOKEN");
    }

    /**
     * @param string $ip
     * @return string
     */
    public function getApiURL($ip): string
    {
        return "https://ipinfo.io/{$ip}?token=$this->token";
    }

    /**
     * @param Response $response
     * @return array
     */
    #[ArrayShape(["country" => "string", "city" => "string", "lat" => "string", "long" => "string", "timezone" => "string"])]
    public function reformatResponse(Response $response): array
    {
        $location = explode(",", $response["loc"]);
        return [
            "country" => $response["country"],
            "city" => $response["city"],
            "lat" => $location[0],
            "long" => $location[1],
            "timezone" => $response["timezone"]
        ];
    }
}
