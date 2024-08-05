<?php

namespace App\Utils;

use App\Models\Currency;
use Illuminate\Support\Facades\App;

class helper
{



    public static function currency()
    {
        // Get the currency symbol for the company
        $lang=App::getLocale();
        $currency = Currency::select('symble_' . $lang . ' as symbol')->first();

        if ($currency) {
            return $currency->symbol;
        } else {
            return 'KWD';
        }
    }
}
