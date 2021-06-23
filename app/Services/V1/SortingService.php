<?php


namespace App\Services\V1;

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
                    return $firstHotel->hotelPricing->startingAt->plain > $secondHotel->hotelPricing->startingAt->plain;
                });

                break;
            case "2":
                usort($fetchedHotels,function($firstHotel, $secondHotel)  {
                    return $firstHotel->guestReviews->overallRating < $secondHotel->guestReviews->overallRating;
                });
                break;
            case 3:
                break;
        }
        return $fetchedHotels;
    }

}
