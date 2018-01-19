<?php

namespace App\Utility;

use Cake\ORM\TableRegistry;

//TODO: Move GetTables Methods From Other Utilities To Here
class Tables
{
    public static function getCurrencyTable()
    {
        $Table = TableRegistry::get('currencies');

        return $Table;
    }

    public static function getWalletTransactionTable()
    {
        $Table = TableRegistry::get('wallet_transactions');

        return $Table;
    }

    public static function getWalletsTable()
    {
        $Table = TableRegistry::get('wallets');

        return $Table;
    }

    public static function getInvitesTable()
    {
        $Table = TableRegistry::get('invites');

        return $Table;
    }

    public static function getInvitesClaimedTable()
    {
        $Table = TableRegistry::get('invites_claimed');

        return $Table;
    }

    public static function getProductsTable()
    {
        $Table = TableRegistry::get('products');

        return $Table;
    }

    public static function getVendorsTable()
    {
        $Table = TableRegistry::get('vendors');

        return $Table;
    }

    public static function getUsersTable()
    {
        $Table = TableRegistry::get('users');

        return $Table;
    }

    public static function getOrdersTable()
    {
        $Table = TableRegistry::get('orders');

        return $Table;
    }

    public static function getMessagesTable()
    {
        $Table = TableRegistry::get('messages');

        return $Table;
    }
}