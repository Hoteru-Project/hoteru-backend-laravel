<?php


namespace App\Services\V1;




class FilterContractService implements FilterContract {

    protected  SearchService $searchService;
    protected $receivedHotels;
    protected array $filteredHotels = [];

    function __construct($hotels) {
        $this->receivedHotels = $hotels;
    }

    public function filterHotels($filterParams) {
        $hotels = $this->receivedHotels;

        // calls the ignore case function to compare the required filter and the existing hotels
        foreach ($hotels as $hotel){$hotel->mainAmenities = $this->ignoreCase($hotel->mainAmenities);}
        $filterParams= $this->ignoreCase( explode('-', $filterParams) );

        // checks if the required filter in the url matches any of the existing features in the apis
        foreach ($hotels as $hotel){
            if ( $this->checkRequiredFilter( $filterParams,$hotel->mainAmenities) ) {
                array_push($this->filteredHotels, $hotel);
            }
        }
    }

    // returns a boolean value depending on if at least one required filter matches any existing hotels in the api
    public function checkRequiredFilter($filterParams,$existingFeatures): bool {
        return !array_diff($filterParams,$existingFeatures);
    }

    // used in comparing on a case insensitive base
    public function ignoreCase($filterParams) {
        $j = 0;
        foreach( $filterParams as $element ) {
            $filterParams[$j] = strtolower($element);
            $j++;
        }
        return $filterParams;
    }

    // returns hotels after filtration process
    public function getFilteredHotels(): array {
        return $this->filteredHotels;
    }

    // Test URLs => {
    //      http://127.0.0.1:8001/api/v1/hotels/search?checkIn=2021-06-07&checkOut=2021-06-08&location=alexandria&rooms=1
    //      http://127.0.0.1:8001/api/v1/hotels/search?checkIn=2021-06-07&checkOut=2021-06-08&location=alexandria&rooms=1&filter=pool-wrong
    //      http://127.0.0.1:8001/api/v1/hotels/search?checkIn=2021-06-07&checkOut=2021-06-08&location=alexandria&rooms=1&filter=pool-wifi
    //    }
}

