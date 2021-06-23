<?php


namespace App\Services\V1;

use Illuminate\Support\Facades\Log;

class SortingService {
    protected array $receivedHotels;
    protected int $sortingID;

    function __construct($hotels,$sentID) {
        $this->receivedHotels = $hotels;
        $this->sortingID = $sentID;
    }

    public function sortSentHotels() {
        $sortMode = $this->sortingID;
        $fetchedHotels = $this->receivedHotels;

        switch ($sortMode) {
            case "1":
                usort($fetchedHotels,function($firstHotel, $secondHotel)  {
                    return ($firstHotel->hotelPricing->startingAt->plain - $secondHotel->hotelPricing->startingAt->plain) * 100;
                });

                break;
            case "2":
                usort($fetchedHotels,function($firstHotel, $secondHotel)  {
                    return ($firstHotel->guestReviews->overallRating - $secondHotel->guestReviews->overallRating) * -100;
//                    Log::info("hotels: ".$firstHotel->name . " vs ". $secondHotel->name);
//                    Log::info("rate: ".$firstHotel->guestReviews->overallRating . " vs ". $secondHotel->guestReviews->overallRating . " $num ");
//                    Log::info("type: ".gettype($firstHotel->guestReviews->overallRating) . " vs ". gettype($secondHotel->guestReviews->overallRating) . " $num ");
                });
                break;
            case 3:
                break;
        }
//        dd($fetchedHotels);
        return $fetchedHotels;
    }

}
