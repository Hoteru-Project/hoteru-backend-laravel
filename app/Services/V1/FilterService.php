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
            if ($this->checkRequiredFilter($this->ignoreCase($this->receivedHotels[$i]->mainAmenities), $filterParams)) {
                array_push($this->filteredHotels, $this->receivedHotels[$i]);
            }
        }
    }

    public function checkRequiredFilter($filteringFeatures, $filterParams) {
        $filterParams = explode('&', $filterParams);
        $filterParams =$this->ignoreCase($filterParams);
        if (!empty(array_intersect($filteringFeatures, $filterParams))) return true;
        return false;
    }

    public function ignoreCase($filterParams) {
        $j = 0;
        foreach( $filterParams as $element ) {
            $filterParams[$j] = strtolower($element);
            $j++;
        }
        return $filterParams;
    }

    public function getFilteredHotels() {
        return $this->filteredHotels;
    }

    // Test URLs => {
    //    http://127.0.0.1:8001/api/v1/hotels/alexandria/filter=POOL
    //    http://127.0.0.1:8001/api/v1/hotels/alexandria/filter=pool&WIFI
    //    http://127.0.0.1:8001/api/v1/hotels/alexandria/filter=pool
    //    http://127.0.0.1:8001/api/v1/hotels/alexandria/filter=pool&wifi
    //    }
}

