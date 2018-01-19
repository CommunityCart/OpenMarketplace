<?php

namespace App\Utility;

use Cake\ORM\TableRegistry;
use App\Utility\Currency;
use App\Utility\Tables;
use App\Utility\Litecoin;

class Wallet {

    public static $ordersEscrowResult;

    public static function getWalletTable()
    {
        return Tables::getWalletsTable();
    }

    public static function getOrdersTable()
    {
        return Tables::getOrdersTable();
    }

    public static function getProductsTable()
    {
        return Tables::getProductsTable();
    }

    public static function getVendorTable()
    {
        return Tables::getVendorsTable();
    }

    public static function getUsersTable()
    {
        return Tables::getUsersTable();
    }

    public static function getWalletByUserID($user_id)
    {
        $walletsTable = Tables::getWalletsTable();

        $wallet = $walletsTable->find('all')->where(['user_id' => $user_id])->first();

        if(!isset($wallet)) {

            MenuCounts::updateUserViewedWallet($user_id);

            $litecoin = new Litecoin();

            $walletAddress = $litecoin->generateNewDepositAddress($user_id);
            $privateKeyUnencrypted = $litecoin->getPrivateKeyByAddress($walletAddress);

            $newWallet = $walletsTable->newEntity([
                'user_id' => $user_id,
                'currency_id' => 4,
                'address' => $walletAddress,
                'private_key' => $privateKeyUnencrypted,
                'wallet_balance' => 0,
                'created' => new \DateTime('now')
            ]);

            $walletsTable->save($newWallet);

            $wallet = $walletsTable->find('all')->where(['user_id' => $user_id])->first();
        }

        return $wallet;
    }

    public static function getWalletBalance($user_id)
    {
        $user = Users::getUser($user_id);

        $totalBalance = $user->get('balance');

        $total = self::getEscrowCrypto($user_id);

        $totalCryptoBalance = $totalBalance - $total;
        $totalBalance = Currency::ConvertToUSD('cmc', $totalBalance);

        $totalBalance = $totalBalance - Currency::ConvertToUSD('cmc', $total);

        return array($totalBalance, $totalCryptoBalance);
    }

    public static function getOrdersEscrowDollars($user_id)
    {
        $vendor = Vendors::getVendor(Vendors::getVendorID($user_id));

        $productsTable = self::getProductsTable();

        $products = $productsTable->find('all')->where(['vendor_id' => $vendor->get('id')])->all();

        $ordersTable = self::getOrdersTable();

        $total = 0;

        foreach($products as $product) {

            $orders = $ordersTable->find('all')->where(['product_id' => $product->get('id'), 'status >' => 1, 'status <' => 5, 'paid_vendor' => 0])->all();

            foreach ($orders as $order) {

                $total = $total + $order->get('order_total_dollars');
            }
        }

        return $total;
    }

    public static function getOrdersEscrowCrypto($user_id)
    {
        $vendor = Vendors::getVendor(Vendors::getVendorID($user_id));

        $productsTable = self::getProductsTable();

        $products = $productsTable->find('all')->where(['vendor_id' => $vendor->get('id')])->all();

        $ordersTable = self::getOrdersTable();

        $total = 0;

        foreach($products as $product) {

            $orders = $ordersTable->find('all')->where(['product_id' => $product->get('id'), 'status >' => 1, 'status <' => 5, 'paid_vendor' => 0])->all();

            foreach ($orders as $order) {

                $total = $total + $order->get('order_total_crypto');
            }
        }

        return $total;
    }

    public static function getEscrowDollars($user_id)
    {
        $ordersTable = self::getOrdersTable();

        if(!isset(self::$ordersEscrowResult) || self::$ordersEscrowResult == null) {

            self::$ordersEscrowResult = $ordersTable->find('all')->where(['user_id' => $user_id, 'status >' => 1, 'paid_vendor' => 0])->all();
        }

        $total = 0;

        foreach(self::$ordersEscrowResult as $order) {

            $total = $total + $order->get('order_total_dollars');
        }

        return $total;
    }

    public static function getEscrowCrypto($user_id)
    {
        $ordersTable = self::getOrdersTable();

        if(!isset(self::$ordersEscrowResult) || self::$ordersEscrowResult == null) {

            self::$ordersEscrowResult = $ordersTable->find('all')->where(['user_id' => $user_id, 'status >' => 1, 'paid_vendor' => 0])->all();
        }

        $total = 0;

        foreach(self::$ordersEscrowResult as $order) {

            $total = $total + $order->get('order_total_crypto');
        }

        return number_format($total, 8);
    }
}