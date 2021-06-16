<?php


namespace App\Services\V1;

use App\Services\V1\FormatterService;
use App\Services\V1\SearchService;
use App\Services\V1\FilterService;
use Illuminate\Support\Facades\Request;


class SortingService {
    protected array $receivedHotels;
    protected int $sortingID;

    function __construct($hotels,$sentID) {
        $this->receivedHotels = $hotels;
        $this->sortingID = $sentID;
    }


    public function sortSentHotels() {
        $sortMode = $this->sortingID;
        $unSortedHotels = $this->receivedHotels;
        $sortedHotels = [];
        switch ($sortMode) {
            case 1:
                $sortedHotels = $this->sortByPricing($unSortedHotels);
                break;
            case 2:
                $sortedHotels = $this->sortByRating($unSortedHotels);
                break;
            case 3:
                break;
        }
        return $sortedHotels;
    }

    public function sortByPricing($hotels) {

        for($i=0;$i<count($hotels);$i++) {
            $val = $hotels[$i]->hotelPricing->startingAt->plain;
            $j = $i-1;
            while($j>=0 && $hotels[$j]->hotelPricing->startingAt->plain > $val){
                $hotels[$j+1]->hotelPricing->startingAt->plain = $hotels[$j]->hotelPricing->startingAt->plain;
                $j--;
            }
            $hotels[$j+1]->hotelPricing->startingAt->plain = $val;
        }
        return $hotels;
    }

    public function sortByRating($hotels) {

        for($i=0;$i<count($hotels);$i++) {
            $val = $hotels[$i]->guestReviews->overallRating;
            $j = $i-1;
            while($j>=0 && $hotels[$j]->guestReviews->overallRating > $val){
                $hotels[$j+1]->guestReviews->overallRating = $hotels[$j]->guestReviews->overallRating;
                $j--;
            }
            $hotels[$j+1]->guestReviews->overallRating = $val;
        }
        return $hotels;
    }

}
