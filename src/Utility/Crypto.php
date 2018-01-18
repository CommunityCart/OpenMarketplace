<?php

namespace App\Utility;
use Cake\Utility\Security;

class Crypto
{
    public static function getRandom($length = 8)
    {
        $bytes = random_bytes($length);

        return bin2hex($bytes);
    }

    public static function decryptCookie($value)
    {
        $prefix = 'Q2FrZQ==.';
        $value = base64_decode(substr($value, strlen($prefix)));

        return Security::decrypt($value, Security::salt());
    }

    public static function encryptMessage($message, $pgp_key)
    {
        try {
            putenv("GNUPGHOME=/tmp");

            $res = gnupg_init();
            $rtv = gnupg_import($res, $pgp_key);
            $enc = gnupg_encrypt($res, $message);
        }catch (\Exception $exception)
        {

        }

        return $enc;
    }
}