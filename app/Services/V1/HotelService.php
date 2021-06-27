<?php

namespace App\Services\V1;

use App\Repositories\V1\SearchRepository;
use App\Services\V1\FetchIPInfo\IPApiProviderService;
use App\Services\V1\FetchIPInfo\IPInfoProviderService;
use Carbon\Carbon;

class HotelService
{

    private SearchRepository $searchRepository;
    private SearchService $searchService;

    public function __construct(SearchRepository $searchRepository, SearchService $searchService)
    {
        $this->searchRepository = $searchRepository;
        $this->searchService = $searchService;
    }

    public function getPopular($data)
    {
        return $this->searchRepository->getOrderedByType($data["type"], "count", false, 10);
    }
    public function getNearHotels($ip)
    {
        $user = auth("api")->user();
        $ipInfo = (new IPApiProviderService())->fetch($ip) ?? (new IPInfoProviderService())->fetch($ip);
        $location = "{$ipInfo['city']}, {$ipInfo['country']}";
        $query = [
            "location" => $location,
            "checkIn" => Carbon::now()->toDateString(),
            "checkOut" => Carbon::now()->addDays(3)->toDateString(),
            "rooms" => 1
        ];

        return $this->searchService->getHotels($user, $query);
    }
    public function getRecentHotels($user, $data)
    {
        if ($user)
            return $this->searchRepository->getUserSearches($user, $data["limit"]);
        return [];
    }
}
