<?php

namespace App\Utility;

class Crypto
{
    public static function getRandom($length = 8)
    {
        $bytes = random_bytes($length);

        return bin2hex($bytes);
    }

    public static function encryptMessage($message, $pgp_key)
    {
        putenv("GNUPGHOME=/tmp");

        $res = gnupg_init();
        $rtv = gnupg_import($res, $pgp_key);
        $enc = gnupg_encrypt($res, $message);

        return $enc;
    }
}