<?php

namespace App\Utility;

use App\Utility\Tables;
use App\Utility\Products;
use App\Utility\Users;

class Vendors
{
    public static $vendor;
    private static $vendor_id;

    // TODO: Find places where we did not use this and replace with this.
    public static function getVendor($vendor_id)
    {
        if(self::$vendor_id != $vendor_id) {

            self::$vendor = null;
        }

        if(!isset(self::$vendor) || self::$vendor == null) {

            $vendorsTable = Tables::getVendorsTable();

            self::$vendor = $vendorsTable->find('all')->where(['id' => $vendor_id])->first();
            self::$vendor_id = $vendor_id;
        }

        return self::$vendor;
    }

    public static function getVendorPGP($vendor_id)
    {
        if($vendor_id == 0) {

            return '';
        }

        $user_id = self::getVendorUserIDByVendorID($vendor_id);

        $users = new Users();
        $user = $users->getUserById($user_id);

        if(isset($user)) {

            return $user->get('pgp');
        }
        else {

            return null;
        }
    }

    public static function getVendorID($user_id)
    {
        if(!isset(self::$vendor) || self::$vendor == null || self::$vendor->get('user_id') != $user_id) {

            $vendorsTable = Tables::getVendorsTable();

            self::$vendor = $vendorsTable->find('all')->where(['user_id' => $user_id])->first();

            if(!isset(self::$vendor)) {

                self::$vendor_id = 0;
            }
            else {

                self::$vendor_id = self::$vendor->get('id');
            }
        }

        if(isset(self::$vendor)) {

            return self::$vendor->get('id');
        }
        else {

            return 0;
        }
    }

    public static function getVendorIDByOrder($order)
    {
        $product = Products::getProduct($order->get('product_id'));

        return $product->get('vendor_id');
    }

    public static function getVendorUserIDByOrder($order)
    {
        $vendor_id = self::getVendorIDByOrder($order);

        return self::getVendorUserIDByVendorID($vendor_id);
    }

    public static function getVendorUserIDByVendorID($vendor_id)
    {
        $vendor = self::getVendor($vendor_id);

        return $vendor->get('user_id');
    }
}