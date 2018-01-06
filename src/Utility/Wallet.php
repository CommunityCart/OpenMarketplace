<?php

namespace App\Utility;

use Cake\ORM\TableRegistry;

class Wallet {

    public static function getWalletTable()
    {
        $Table = TableRegistry::get('wallets');

        return $Table;
    }

    public static function getWalletBalance($user_id)
    {
        $walletsTable = self::getWalletTable();

        $wallets = $walletsTable->find('all', ['contain' => ['Users', 'Currencies']])->where(['Wallets.user_id' => $user_id, 'Wallets.currency_id' => '4'])->all();

        $totalBalance = 0;

        foreach($wallets as $wallet)
        {
            $totalBalance = $totalBalance + $wallet->wallet_balance;
        }

        $totalBalance = \App\Utility\Currency::ConvertToUSD('cmc', $totalBalance);

        return $totalBalance;
    }
}