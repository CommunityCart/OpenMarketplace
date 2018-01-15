<?php

namespace App\Utility;

use Cake\ORM\TableRegistry;
use Cake\Core\Configure;

// TODO: Settings Placeholders converted to actual code
class Settings
{
    public static function getVendorCommission()
    {
        return 1;
    }

    public static function getUserCommission()
    {
        return 1;
    }

    public static function getAdminsCommission()
    {
        return 1;
    }

    public static function getSuperAdminsCommission()
    {
        return 1;
    }

    public static function getVendorCommissionPercent()
    {
        return self::getVendorCommission() / 100;
    }

    public static function getUserCommissionPercent()
    {
        return self::getUserCommission() / 100;
    }

    public static function getAdminsCommissionPercent()
    {
        return self::getAdminsCommission() / 100;
    }

    public static function getSuperAdminsCommissionPercent()
    {
        return self::getSuperAdminsCommission() / 100;
    }

    public static function getInviteMax()
    {
        return -1;
    }

    public static function registerInviteOnly()
    {
        return true;
    }
}