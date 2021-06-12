<?php


namespace App\Services\V1;


class FilterService implements Filter {

    protected $receivedHotels;
    protected $filteredHotels = [];

    function __construct($hotels, $cityName) {
        $this->receivedHotels = $hotels;
        $this->cityName = $cityName;
    }

    public function filterHotels($filterParams) {
        for ($i = 0; $i < count($this->receivedHotels); $i++) {
            if ($this->checkRequiredFilter( $filterParams,$this->ignoreCase($this->receivedHotels[$i]->mainAmenities))) {
                array_push($this->filteredHotels, $this->receivedHotels[$i]);
            }
        }
    }


    public function checkRequiredFilter($filterParams,$filteringFeatures) {
        $subSetArray    = $this->ignoreCase(explode('&', $filterParams));
        $srcArray   = $filteringFeatures;
        $isSubset   = array_diff($subSetArray,$srcArray);
        return !$isSubset;
    }

    public function ignoreCase($filterParams) {
        $j = 0;
        foreach( $filterParams as $element ) {
            $filterParams[$j] = strtolower($element);
            $j++;
        }
        return $filterParams;
    }


    public function sortFilteredHotels($filteredHotels) {

        for($i=0;$i<count($filteredHotels);$i++){
            $val = $filteredHotels[$i]->hotelPricing->startingAt->plain;
            $j = $i-1;
            while($j>=0 && $filteredHotels[$j]->hotelPricing->startingAt->plain > $val){
                $filteredHotels[$j+1]->hotelPricing->startingAt->plain = $filteredHotels[$j]->hotelPricing->startingAt->plain;
                $j--;
            }
            $filteredHotels[$j+1]->hotelPricing->startingAt->plain = $val;
        }
        return $filteredHotels;
    }

    public function getFilteredHotels() {
        return $this->sortFilteredHotels($this->filteredHotels);
    }

    // Test URLs => {
    //    http://127.0.0.1:8001/api/v1/hotels/alexandria/filter=POOL
    //    http://127.0.0.1:8001/api/v1/hotels/alexandria/filter=pool&WIFI
    //    http://127.0.0.1:8001/api/v1/hotels/alexandria/filter=pool
    //    http://127.0.0.1:8001/api/v1/hotels/alexandria/filter=pool&wifi
    //    }
}

