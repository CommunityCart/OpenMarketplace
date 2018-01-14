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

    public static function getVendorCommissionPercent()
    {
        return 0.01;
    }

    public static function getUserCommissionPercent()
    {
        return 0.01;
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