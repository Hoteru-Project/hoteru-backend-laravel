<?php

namespace App\Repositories\V1;

use App\Models\Currency;

/**
 * Layer to handle datastore operations. Can be a local operation or external datastore
 */
class CurrencyRepository extends Repository
{
    /**
     * Initializing the instances and variables
     *
     * @param Currency $currency
     */
    public function __construct(Currency $currency)
    {
        $this->model = $currency;
    }


    public function showCurrencies(){
        return $this->model->all();
    }

}
