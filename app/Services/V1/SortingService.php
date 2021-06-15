<?php


namespace App\Services\V1;

use App\Services\V1\FormatterService;
use App\Services\V1\SearchService;
use App\Services\V1\FilterService;
use Illuminate\Support\Facades\Request;


class SortingService {
    protected array $receivedHotels;

    function __construct($hotels,$sortingID) {
        $this->receivedHotels = $hotels["result"];
//        switch ($sortId) {
//            case 1:
//                sorting by price;
//                break;
//            case 2:
//                sorting by rating;
//                break;
//            case 3:
//                sorting by our recommendation
//        }
    }

    public function sortSentHotels($sortId) {
        $hotels = $this->receivedHotels;

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
}
