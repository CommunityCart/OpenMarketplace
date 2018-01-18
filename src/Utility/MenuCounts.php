<?php

namespace App\Utility;

use App\Utility\Tables;
use App\Utility\Messages;


class MenuCounts
{
    public static function getShoppingCartCounts($user)
    {
        $labels = '';
        $greenCount = $user->get('viewed_shopping_cart');
        $redCount = $user->get('viewed_shopping_cart_red');

        if($greenCount > 0) {

            $labels = '<small class="label pull-right bg-green">' . $greenCount . '</small>';
        }

        if($redCount > 0) {

            $labels = $labels . '<small class="label pull-right bg-red">' . $redCount . '</small>';
        }

        return $labels;
    }

    public static function getWalletCount($user)
    {
        $labels = '';
        $greenCount = $user->get('viewed_wallet');

        if($greenCount > 0) {

            $labels = '<small class="label pull-right bg-green-gradient">' . $greenCount . '</small>';
        }

        return $labels;
    }

    public static function getMessageCounts($user_id)
    {
        $mCount = Messages::getUserCount($user_id);

        $mVendorCount = Messages::getVendorCount(Vendors::getVendorID($user_id));

        $messageCount = '';

        if($mCount > 0) {

            $messageCount = '<small class="label pull-right bg-green">' . $mCount . '</small>';
        }

        if($mVendorCount > 0) {

            $messageCount = $messageCount . '<small class="label pull-right bg-green-active">' . $mVendorCount . '</small>';
        }

        return $messageCount;
    }

    public static function getDisputesCount($user)
    {
        $labels = '';
        $yellowCount = $user->get('viewed_disputes');

        if($yellowCount > 0) {

            $labels = '<small class="label pull-right bg-yellow">' . $yellowCount . '</small>';
        }

        return $labels;
    }

    public static function getInvitesCount($user)
    {
        $labels = '';
        $greenCount = $user->get('viewed_invites');

        if($greenCount > 0) {

            $labels = '<small class="label pull-right bg-green-active">' . $greenCount . '</small>';
        }

        return $labels;
    }

    public static function getVendorIncomingCounts($vendor)
    {
        $labels = '';
        $greenCount = $vendor->get('viewed_incoming');

        if($greenCount > 0) {

            $labels = '<small class="label pull-right bg-green">' . $greenCount . '</small>';
        }

        return $labels;
    }

    public static function getVendorFinalizedCounts($vendor)
    {
        $labels = '';
        $greenCount = $vendor->get('viewed_finalized');

        if($greenCount > 0) {

            $labels = '<small class="label pull-right bg-green-gradient">' . $greenCount . '</small>';
        }

        return $labels;
    }

    public static function getVendorDisputedCounts($vendor)
    {
        $labels = '';
        $greenCount = $vendor->get('viewed_disputed');

        if($greenCount > 0) {

            $labels = '<small class="label pull-right bg-red">' . $greenCount . '</small>';
        }

        return $labels;
    }

    public static function updateUserViewedShoppingCart($user_id, $red = false, $reset = false)
    {
        $userTable = Tables::getUsersTable();
        $user = Users::getUser($user_id);

        if($reset == false) {

            if($red == true) {

                $user->set('viewed_shopping_cart_red', $user->get('viewed_shopping_cart_red') + 1);
            }
            else {

                $user->set('viewed_shopping_cart', $user->get('viewed_shopping_cart') + 1);
            }
        }
        else {

            if($user->get('viewed_shopping_cart') != 0 || $user->get('viewed_shopping_cart_red') != 0) {

                $user->set('viewed_shopping_cart', 0);
                $user->set('viewed_shopping_cart_red', 0);
            }
        }
        $userTable->save($user);
    }

    public static function updateUserViewedWallet($user_id, $reset = false)
    {
        $userTable = Tables::getUsersTable();
        $user = Users::getUser($user_id);
        if ($reset == false) {

            $user->set('viewed_wallet', $user->get('viewed_wallet') + 1);
        }
        else {

            if($user->get('viewed_wallet') != 0) {

                $user->set('viewed_wallet', 0);
            }
        }
        $userTable->save($user);
    }

    public static function updateUserViewedDisputes($user_id, $reset = false)
    {
        $userTable = Tables::getUsersTable();
        $user = Users::getUser($user_id);
        if ($reset == false) {

            $user->set('viewed_disputes', $user->get('viewed_disputes') + 1);
        }
        else {

            if($user->get('viewed_disputes') != 0) {

                $user->set('viewed_disputes', 0);
            }
        }
        $userTable->save($user);
    }

    public static function updateUserViewedInvites($user_id, $reset = false)
    {
        $userTable = Tables::getUsersTable();
        $user = Users::getUser($user_id);
        if ($reset == false) {

            $user->set('viewed_invites', $user->get('viewed_invites') + 1);
        }
        else {

            if($user->get('viewed_invites') != 0) {

                $user->set('viewed_invites', 0);
            }
        }
        $userTable->save($user);
    }

    public static function updateVendorViewedIncoming($vendor_id, $reset = false)
    {
        $vendorsTable = Tables::getVendorsTable();
        $vendor = $vendorsTable->find('all')->where(['id' => $vendor_id])->first();
        if($reset == false) {

            $vendor->set('viewed_incoming', $vendor->get('viewed_incoming') + 1);
        }
        else {

            if($vendor->get('viewed_incoming') != 0) {

                $vendor->set('viewed_incoming', 0);
            }
        }
        $vendorsTable->save($vendor);
    }

    public static function updateVendorViewedFinalized($vendor_id, $reset = false)
    {
        $vendorsTable = Tables::getVendorsTable();
        $vendor = $vendorsTable->find('all')->where(['id' => $vendor_id])->first();
        if($reset == false) {

            $vendor->set('viewed_finalized', $vendor->get('viewed_finalized') + 1);
        }
        else {

            if($vendor->get('viewed_finalized') != 0) {

                $vendor->set('viewed_finalized', 0);
            }
        }
        $vendorsTable->save($vendor);
    }

    public static function updateVendorViewedDisputed($vendor_id, $reset = false)
    {
        $vendorsTable = Tables::getVendorsTable();
        $vendor = $vendorsTable->find('all')->where(['id' => $vendor_id])->first();
        if($reset == false) {

            $vendor->set('viewed_disputed', $vendor->get('viewed_disputed') + 1);
        }
        else {

            if($vendor->get('viewed_disputed') != 0) {

                $vendor->set('viewed_disputed', 0);
            }
        }
        $vendorsTable->save($vendor);
    }
}