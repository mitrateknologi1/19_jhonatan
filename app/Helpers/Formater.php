<?php

namespace App\Helpers;

class Formater
{
    public static function million(int $number): string
    {
        $decima = 3;
        if ($number > 100000000) $decima = 2;
        if ($number > 1000000000) $decima = 1;

        return number_format($number / 1000000, $decima, ',', '.') . 'jt';
    }
}
