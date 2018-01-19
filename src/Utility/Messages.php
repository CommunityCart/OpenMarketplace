<?php

namespace App\Utility;

use App\Utility\Tables;
use App\Utility\Vendors;
use App\Utility\Users;
use App\Utility\Dates;

class Messages
{
    public static $userCount;
    public static $vendorCount;

    public static function getTotalCount($user_id)
    {
        if(!isset(self::$userCount)) {

            $userCount = self::getUserCount($user_id);
        }
        else {

            $userCount = self::$userCount;
        }

        if(!isset(self::$vendorCount)) {

            $vendorCount = self::getVendorCount($user_id);
        }
        else {

            $vendorCount = self::$vendorCount;
        }

        return $userCount + $vendorCount;
    }

    public static function getNavMessages($user_id, $role)
    {
        $messagesArray = array();
        $messagesTable = Tables::getMessagesTable();

        if($role == 'vendor') {

            $vendor_id = Vendors::getVendorID($user_id);

            $messages = $messagesTable->find('all', ['contain' => ['Users', 'Vendors']])->where(['vendor_read' => 0, 'Messages.vendor_id' => $vendor_id, 'vendor_deleted' => 0])->orderDesc('Messages.modified')->limit(3);

            foreach($messages as $message)
            {
                $user = Users::getOtherUserByID($message->get('user_id'));
                $vendor = Vendors::isUserVendor($message->get('user_id'));

                if($vendor != false) {

                    $messageArray['username'] = $vendor->get('title');
                }
                else {

                    $messageArray['username'] = $user->get('username');
                }
                $messageArray['avatar'] = $user->get('avatar');
                $messageArray['subject'] = $message->get('title');
                $messageArray['lapsed'] = Dates::getLapsedTime($message->get('created'));
                $messageArray['id'] = $message->get('id');

                $messagesArray[] = $messageArray;
            }
        }

        $messages = $messagesTable->find('all', ['contain' => ['Users', 'Vendors']])->where(['user_read' => 0, 'Messages.user_id' => $user_id, 'user_deleted' => 0])->orderDesc('Messages.modified')->limit(3);

        foreach($messages as $message)
        {
            $user = Users::getOtherUserByID($message->get('user_id'));
            $vendor = Vendors::isUserVendor($message->get('user_id'));

            if($vendor != false) {

                $messageArray['username'] = $vendor->get('title');
            }
            else {

                $messageArray['username'] = $user->get('username');
            }
            $messageArray['avatar'] = $user->get('avatar');
            $messageArray['subject'] = $message->get('title');
            $messageArray['lapsed'] = Dates::getLapsedTime($message->get('created'));
            $messageArray['id'] = $message->get('id');

            $messagesArray[] = $messageArray;
        }

        return $messagesArray;
    }

    public static function getUserCount($user_id)
    {
        if(isset(self::$userCount)) {

            return self::$userCount;
        }

        $messagesTable = Tables::getMessagesTable();

        $userCount = $messagesTable->find('all', ['contain' => ['Users', 'Vendors']])->where(['user_read' => 0, 'Messages.user_id' => $user_id, 'user_deleted' => 0])->count();

        self::$userCount = $userCount;

        return $userCount;
    }

    public static function getVendorCount($vendor_id)
    {
        if($vendor_id == 0) {

            return 0;
        }

        if(isset(self::$vendorCount)) {

            return self::$vendorCount;
        }

        $messagesTable = Tables::getMessagesTable();

        $vendorCount = $messagesTable->find('all', ['contain' => ['Users', 'Vendors']])->Where(['vendor_read' => 0, 'Messages.vendor_id' => $vendor_id, 'vendor_deleted' => 0])->count();

        self::$vendorCount = $vendorCount;

        if(!isset($vendorCount)) {

            return 0;
        }

        return $vendorCount;
    }
}