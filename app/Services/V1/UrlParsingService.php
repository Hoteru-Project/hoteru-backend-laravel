<?php


namespace App\Services\V1;


class UrlParsingService {

    // a generic function that checks if a sorting or a filtering service is required
    public function getServiceParams($requestedService):string {
        $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $queryStr = parse_url($url, PHP_URL_QUERY);
        parse_str($queryStr, $queryParams);
        array_key_exists($requestedService,$queryParams) ? $serviceParams = $queryParams[$requestedService] : $serviceParams = "";
        return $serviceParams;
    }

    // checks if a certain service is requested in the url
    public function isServiceRequired($service): bool {
        return !empty($this->getServiceParams($service));
    }
}
