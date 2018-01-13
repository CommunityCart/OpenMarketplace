<?php

namespace App\Utility;

use Cake\ORM\TableRegistry;

class Wallet {

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

    public static function getUsersTable()
    {
        $Table = TableRegistry::get('users');

        return $Table;
    }

    public static function getWalletBalance($user_id)
    {
        $usersTable = self::getUsersTable();

        $user = $usersTable->find('all')->where(['id' => $user_id])->first();

        $totalBalance = $user->get('balance');

        $total = self::getEscrow($user_id);

        $totalCryptoBalance = $totalBalance - \App\Utility\Currency::Convert('usd', $total, 'cmc');
        $totalBalance = \App\Utility\Currency::ConvertToUSD('cmc', $totalBalance);

        $totalBalance = $totalBalance - $total;

        return array($totalBalance, $totalCryptoBalance);
    }

    public static function getEscrow($user_id)
    {
        $ordersTable = self::getOrdersTable();
        $productsTable = TableRegistry::get('products');
        $shippingTable = TableRegistry::get('shipping_options');

        $orders = $ordersTable->find('all')->where(['user_id' => $user_id, 'status >' => 1, 'paid_vendor' => 0])->all();

        $total = 0;

        foreach($orders as $order) {

            $product = $productsTable->find('all')->where(['id' => $order->get('product_id')])->first();
            $shipping = $shippingTable->find('all')->where(['id' => $order->get('shipping_option_id')])->first();

            $total = $total + (($product->get('cost') * $order->get('quantity')) + $shipping->get('shipping_cost'));
        }

        return $total;
    }
}