<?php

namespace App\Utility;

use App\Utility\Tables;

class Messages
{
    public static function getUserCount($user_id)
    {
        $messagesTable = Tables::getMessagesTable();

        $userCount = $messagesTable->find('all', ['contain' => ['Users', 'Vendors']])->where(['user_read' => 0, 'Messages.user_id' => $user_id, 'user_deleted' => 0])->count();

        return $userCount;
    }

    public static function getVendorCount($vendor_id)
    {
        $messagesTable = Tables::getMessagesTable();

        $vendorCount = $messagesTable   ->find('all', ['contain' => ['Users', 'Vendors']])->Where(['vendor_read' => 0, 'Messages.vendor_id' => $vendor_id, 'vendor_deleted' => 0])->count();

        return $vendorCount;
    }
}