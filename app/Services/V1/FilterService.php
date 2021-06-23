<?php


namespace App\Services\V1;




use App\Contracts\V1\FilterContract;

class FilterService implements FilterContract {

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

    // return hotels based on hotel stars score ( 1 - 5 )
    public function filterByStars($stars): array {

        $hotels = $this->receivedHotels;
        $matchedHotels = [];

        switch ($stars) {
            case "one":     $rate = 1; break;
            case "two":     $rate = 2; break;
            case "three":   $rate = 3; break;
            case "four":    $rate = 4; break;
            case "five":    $rate = 5; break;
            default:        $rate = 5;
        }
        foreach ($hotels as $hotel) {
            $hotel->classRating != $rate ?: array_push($matchedHotels,$hotel);
        }
        return $matchedHotels;
    }

    // filters hotels based on overAll rating between ranges
    public function filterInRange($class){
        //         overallRating >= 8.5 => class A => 'Excellent'
        // 8.5  >  overallRating >= 8.0 => class B => 'Very good'
        // 8.0  >  overallRating >= 7.5 => class C => 'Good'
        // 7.5  >  overallRating >= 7.0 => class D => 'Fair'
        // 7.0  >  overallRating        => class E => 'Okay'

        function in_range ($number, $min, $max, $inclusive = FALSE) {
            if (is_double($number) && is_double($min) && is_double($max)) {
                return $inclusive
                    ? ($number >= $min && $number <= $max)
                    : ($number > $min && $number < $max) ;
            }
            return FALSE;
        }

        switch ($class) {
            case "A": $max = 10.0; $min = 8.5; break;
            case "B": $max = 8.5;  $min = 8.0; break;
            case "C": $max = 8.0;  $min = 7.5; break;
            case "D": $max = 7.5;  $min = 7.0; break;
            case "E": $max = 7.0;  $min = 0.0; break;
        }
        $hotels = $this->receivedHotels;
        $matchedHotels = [];
        foreach ($hotels as $hotel) {
            ! in_range($hotel->guestReviews->overallRating,$min,$max)?: array_push($matchedHotels,$hotel) ;
        }
        dd($matchedHotels);
        return $matchedHotels;
    }

    // returns hotels after filtration process
    public function getFilteredHotels(): array {
        return $this->filteredHotels;
    }

}

