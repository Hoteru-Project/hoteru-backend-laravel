<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;
use Tymon\Support\Facades\DB;

class CurrenciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Currency::insert([
            ['code' =>'AFN' , 'name' => 'Afghani', 'symbol' => '؋' ],
            ['code' =>'ALL' , 'name' => 'Lek', 'symbol' => 'Lek' ],
            ['code' =>'ANG' , 'name' => 'Netherlands Antillian Guilder', 'symbol' => 'ƒ' ],
            ['code' =>'ARS' , 'name' => 'Argentine Peso', 'symbol' => '$' ],
            ['code' =>'AUD' , 'name' => 'Australian Dollar', 'symbol' => '$' ],
            ['code' =>'AWG' , 'name' => 'Aruban Guilder', 'symbol' => 'ƒ' ],
            ['code' =>'AZN' , 'name' => 'Azerbaijanian Manat', 'symbol' => 'ман' ],
            ['code' =>'BAM' , 'name' => 'Convertible Marks', 'symbol' => 'KM' ],
            ['code' => 'BDT', 'name' => 'Bangladeshi Taka', 'symbol' => '৳'],
            ['code' =>'BBD' , 'name' => 'Barbados Dollar', 'symbol' => '$' ],
            ['code' =>'BRL' , 'name' => 'Brazilian Real', 'symbol' => 'R$' ],
            ['code' =>'BSD' , 'name' => 'Bahamian Dollar', 'symbol' => '$' ],
            ['code' =>'BWP' , 'name' => 'Pula', 'symbol' => 'P' ],
            ['code' =>'BYR' , 'name' => 'Belarussian Ruble', 'symbol' => '₽' ],
            ['code' =>'BZD' , 'name' => 'Belize Dollar', 'symbol' => 'BZ$' ],
            ['code' =>'CAD' , 'name' => 'Canadian Dollar', 'symbol' => '$' ],
            ['code' =>'CHF' , 'name' => 'Swiss Franc', 'symbol' => 'CHF' ],
            ['code' =>'CLP' , 'name' => 'CLF Chilean Peso Unidades de fomento', 'symbol' => '$' ],
            ['code' =>'CNY' , 'name' => 'Yuan Renminbi', 'symbol' => '¥' ],
            ['code' =>'CZK' , 'name' => 'Czech Koruna', 'symbol' => 'Kč' ],
            ['code' =>'EGP' , 'name' => 'Egyptian Pound', 'symbol' => '£' ],
            ['code' =>'EUR' , 'name' => 'Euro', 'symbol' => '€' ],
            ['code' =>'GYD' , 'name' => 'Guyana Dollar', 'symbol' => '$' ],
            ['code' =>'HKD' , 'name' => 'Hong Kong Dollar', 'symbol' => '$' ],
            ['code' =>'IRR' , 'name' => 'Iranian Rial', 'symbol' => '﷼' ],
            ['code' =>'JMD' , 'name' => 'Jamaican Dollar', 'symbol' => 'J$' ],
            ['code' =>'JPY' , 'name' => 'Yen', 'symbol' => '¥' ],
            ['code' =>'MNT' , 'name' => 'Tugrik', 'symbol' => '₮' ],
            ['code' =>'MUR' , 'name' => 'Mauritius Rupee', 'symbol' => '₨' ],
            ['code' =>'MXN' , 'name' => 'MXV Mexican Peso Mexican Unidad de Inversion (UDI]', 'symbol' => '$' ],
            ['code' =>'PAB' , 'name' => 'USD Balboa US Dollar', 'symbol' => 'B/.' ],
            ['code' =>'USD' , 'name' => 'US Dollar', 'symbol' => '$' ],
            ['code' =>'UYU' , 'name' => 'UYI Uruguay Peso en Unidades Indexadas', 'symbol' => '$U' ],
            ['code' =>'ZAR' , 'name' => 'Rand', 'symbol' => 'R' ],
        ]);
    }
}
