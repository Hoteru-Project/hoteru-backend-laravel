<?php


namespace App\Services\V1;




class FilterService implements Filter {

    protected  SearchService $searchService;
    protected $receivedHotels;
    protected $filteredHotels = [];

    function __construct($hotels) {
        $this->receivedHotels = $hotels["result"];
    }

    public function filterHotels($filterParams) {
        for ($i = 0; $i < count($this->receivedHotels); $i++) {
            if ($this->checkRequiredFilter( $filterParams,$this->ignoreCase($this->receivedHotels[$i]->mainAmenities))) {
                array_push($this->filteredHotels, $this->receivedHotels[$i]);
            }
        }
    }


    public function checkRequiredFilter($filterParams,$filteringFeatures): bool
    {
        $subSetArray    = $this->ignoreCase(explode('-', $filterParams));
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


    public function getFilteredHotels(): array {
        return $this->filteredHotels;
    }

    // Test URLs => {
    //      http://127.0.0.1:8001/api/v1/hotels/search?checkIn=2021-06-07&checkOut=2021-06-08&location=alexandria&rooms=1
    //      http://127.0.0.1:8001/api/v1/hotels/search?checkIn=2021-06-07&checkOut=2021-06-08&location=alexandria&rooms=1&filter=pool-wrong
    //      http://127.0.0.1:8001/api/v1/hotels/search?checkIn=2021-06-07&checkOut=2021-06-08&location=alexandria&rooms=1&filter=pool-wifi
    //    }
}

