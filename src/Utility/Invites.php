<?php

namespace App\Utility;

use App\Utility\Tables;
use App\Utility\Products;

class Invites
{
    public static function verifyInviteCode($code)
    {
        $invitesTable = Tables::getInvitesTable();

        $inviteQuery = $invitesTable->find('all')->where(['code' => $code])->first();

        if(!isset($inviteQuery)) {

            return false;
        }
        else {

            return $inviteQuery->get('id');
        }
    }

    public static function insertRegistration($user, $inviteId)
    {
        $invitesClaimedTable = Tables::getInvitesClaimedTable();

        $invite = $invitesClaimedTable->newEntity([
            'invite_id' => $inviteId,
            'user_id' => $user->get('id'),
            'upgraded_to_vendor' => 0,
            'vendor_id' => 0,
            'created' => new \DateTime('now')
        ]);

        $invitesClaimedTable->save($invite);
    }

    public static function getVendorInviteID($order)
    {
        $product = Products::getProduct($order->get('product_id'));
        $vendor = Vendors::getVendor($product->get('vendor_id'));
        $userId = $vendor->get('user_id');

        $inviteClaimedTable = Tables::getInvitesClaimedTable();
        $invitee = $inviteClaimedTable->find('all')->where(['user_id' => $userId])->first();

        return $invitee->get('invite_id');
    }

    public static function getUserInviteID($order)
    {
        $inviteClaimedTable = Tables::getInvitesClaimedTable();
        $invitee = $inviteClaimedTable->find('all')->where(['user_id' => $order->get('user_id')])->first();

        return $invitee->get('invite_id');
    }

    // TODO: Upon being made admin, a row must be added to the invites table for that user
    public static function getAdminsInviteIDs()
    {
        $adminIDs = array();

        $inviteTable = Tables::getInvitesTable();

        $usersTable = Tables::getUsersTable();
        $admins = $usersTable->find('all')->where(['role' => 'admin'])->all();

        foreach($admins as $admin)
        {
            $inviter = $inviteTable->find('all')->where(['user_id' => $admin->get('id')])->first();
            $adminIDs[] = $inviter->get('id');
        }

        return $adminIDs;
    }

    // TODO: Upon SuperAdmin being created, a row must be added to the invites table for that user
    public static function getSuperAdminInviteID()
    {
        $inviteTable = Tables::getInvitesTable();

        $usersTable = Tables::getUsersTable();
        $admin = $usersTable->find('all')->where(['role' => 'superadmin'])->first();
        $inviter = $inviteTable->find('all')->where(['user_id' => $admin->get('id')])->first();

        return $inviter->get('id');
    }

    public static function getUserIDByInviteID($invite_id)
    {
        $inviteTable = Tables::getInvitesTable();

        $inviter = $inviteTable->find('all')->where(['id' => $invite_id])->first();

        return $inviter->get('user_id');
    }
}