<?php

namespace App\Utility;

use Cake\ORM\TableRegistry;
use Cake\Core\Configure;

class Invites
{
    public static function getTable()
    {
        $Table = TableRegistry::get('invites');

        return $Table;
    }

    public static function getClaimedTable()
    {
        $Table = TableRegistry::get('invites_claimed');

        return $Table;
    }

    public static function verifyInviteCode($code)
    {
        $invitesTable = self::getTable();

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
        $invitesClaimedTable = self::getClaimedTable();

        $invite = $invitesClaimedTable->newEntity([
            'invite_id' => $inviteId,
            'user_id' => $user->get('id'),
            'upgraded_to_vendor' => 0,
            'vendor_id' => 0,
            'created' => new \DateTime('now')
        ]);

        $invitesClaimedTable->save($invite);
    }
}