<?php

namespace App\Utility;

use Cake\ORM\TableRegistry;
use App\Utility\Currency;

class Wallet {

    public static $ordersEscrowResult;

    public static function getWalletTable()
    {
        $Table = TableRegistry::get('wallets');

        return $Table;
    }

    public static function getOrdersTable()
    {
        $Table = TableRegistry::get('orders');

        return $Table;
    }

    public static function getProductsTable()
    {
        $Table = TableRegistry::get('products');

        return $Table;
    }

    public static function getVendorTable()
    {
        $Table = TableRegistry::get('vendors');

        return $Table;
    }

    public static function getUsersTable()
    {
        $Table = TableRegistry::get('users');

        return $Table;
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

            $orders = $ordersTable->find('all')->where(['product_id' => $product->get('id'), 'status >' => 1, 'paid_vendor' => 0])->all();

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

            $orders = $ordersTable->find('all')->where(['product_id' => $product->get('id'), 'status >' => 1, 'paid_vendor' => 0])->all();

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