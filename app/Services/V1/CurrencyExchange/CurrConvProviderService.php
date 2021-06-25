<?php


namespace App\Services\V1\CurrencyExchange;

use Illuminate\Http\Client\Response;
use JetBrains\PhpStorm\ArrayShape;

class CurrConvProviderService extends FetchFetchCurrencyExchange
{
    /**
     * @var string $token
     */
    private string $token;

    /**
     * @var string $query
     */
    private string $query;


    /**
     * IPInfoProviderService constructor.
     */
    public function __construct()
    {
        $this->token = ENV("CURRCONV_API_KEY");
    }

    /**
     * @param $query
     * @return string
     */
    public function getApiURL($query): string
    {
        $this->query=$query;
        return "https://free.currconv.com/api/v7/convert?q=$query&compact=ultra&apiKey=$this->token";
    }

    /**
     * @param Response $response
     * @return array
     */
    #[ArrayShape(["currency_from_to" => "string", "value" => "double"])]
    public function reformatResponse(Response $response): array
    {
        return [
            "currency_from_to" => $this->query,
            "value" => $response[$this->query]
        ];
    }
}
