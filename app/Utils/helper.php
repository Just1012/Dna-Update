<?php

namespace App\Utils;

use App\Models\Currency;
use Illuminate\Support\Facades\App;

class helper
{

    public static function str_limit_words($string, $word_limit) {
        $words = explode(' ', $string);
        return implode(' ', array_slice($words, 0, $word_limit)) . (count($words) > $word_limit ? '...' : '');
    }
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
