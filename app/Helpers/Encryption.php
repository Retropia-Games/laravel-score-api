<?php

namespace App\Helpers;

class Encryption
{
    /**
     * Decrypt AES data.
     */
    public static function decrypt(string $data, string $key, string $iv): string|false
    {
        $key = hex2bin($key);
        $iv =  hex2bin($iv);

        return openssl_decrypt($data, "AES-128-CBC", $key, OPENSSL_ZERO_PADDING, $iv);
    }
}
