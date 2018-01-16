<?php

namespace App\Utility;

use App\Utility\Tables;
use App\Utility\Products;
use App\Utility\Users;

class Vendors
{
    // TODO: Find places where we did not use this and replace with this.
    public static function getVendor($vendor_id)
    {
        $vendorsTable = Tables::getVendorsTable();

        $vendor = $vendorsTable->find('all')->where(['id' => $vendor_id])->first();

        return $vendor;
    }

    public static function getVendorPGP($vendor_id)
    {
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
        $vendorsTable = Tables::getVendorsTable();

        $vendor = $vendorsTable->find('all')->where(['user_id' => $user_id])->first();

        return $vendor->get('id');
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