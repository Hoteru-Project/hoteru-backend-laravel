<?php


namespace App\Services\V1;

interface Filter
{
    public function filterHotels($filteringFeatures);
    public function getFilteredHotels();
}
