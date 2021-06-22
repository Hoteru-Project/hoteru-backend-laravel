<?php


namespace App\Contracts\V1;

interface FilterContract
{
    public function filterHotels($filteringFeatures);
    public function getFilteredHotels();
}
