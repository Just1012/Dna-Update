<?php

if (!function_exists('str_limit_words')) {
    function str_limit_words($string, $word_limit) {
        $words = explode(' ', $string);
        return implode(' ', array_slice($words, 0, $word_limit)) . (count($words) > $word_limit ? '...' : '');
    }
}
