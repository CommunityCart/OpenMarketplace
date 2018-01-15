<?php

namespace App\Utility;

class Math
{
    public static function roundDown($amount, $precision = 8)
    {
        return self::floordec($amount, $precision);
    }

    public static function roundCryptoDown($amount)
    {
        return number_format(self::roundDown($amount), 8);
    }

    public static function roundDollarsDown($amount)
    {
        return number_format(self::roundDown($amount), 2);
    }

    public static function floordec($zahl,$decimals=2){
        return floor(floor($zahl*pow(10,$decimals)))/pow(10,$decimals) - 0.00000001;
    }
}