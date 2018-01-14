<?php

namespace App\Utility;

use Cake\ORM\TableRegistry;

class Currency {

    public static function getExchangeTable()
    {
        $exchangeTable = TableRegistry::get('exchange_rates');

        return $exchangeTable;
    }

    public static function Convert($from_symbol, $amount, $to_symbol)
    {
        $exchangeTable = self::getExchangeTable();

        $exchangeQuery = $exchangeTable->find('all')->where(['one_unit_of_symbol' => $from_symbol, 'in_symbol' => $to_symbol]);

        $exchangeResult = $exchangeQuery->first();

        return number_format($amount * $exchangeResult->get('is_equal_to'), 8);
    }

    public static function ConvertToUSD($from_symbol, $amount)
    {
        $exchangeTable = self::getExchangeTable();

        $exchangeQuery = $exchangeTable->find('all')->where(['one_unit_of_symbol' => $from_symbol, 'in_symbol' => 'usd']);

        $exchangeResult = $exchangeQuery->first();

        return number_format($amount * $exchangeResult->get('is_equal_to'), 3);
    }
}