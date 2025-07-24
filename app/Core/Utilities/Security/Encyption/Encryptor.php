<?php

namespace App\Core\Utilities\Security\Encyption;


class Encryptor
{
    private static $secretKey = 'Xy7!qZp#9@vW%T1*L4&uC6~HnO+R|J$mS0Bz82Q?F^YdK=g5aE';
    private static $cipher = 'aes-256-cbc';

    // Şifreleme işlemi.
    public static function Encrypt($data)
    {
        // IV uzunluğunu belirle ve rastgele IV üret.
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length(self::$cipher));
        $encrypted = openssl_encrypt($data,self::$cipher, self::$secretKey, 0, $iv);

        // IV'yi ve şifreli veriyi birleştirip Base64 ile encode et.
        return base64_encode($iv . $encrypted);
    }

    // Çözme işlemi.
    public static function Decrypt($data)
    {
        // Base64 ile encode edilen veriyi çöz.
        $data = base64_decode($data);

        // IV'yi ve şifreli veriyi ayır.
        $iv_length = openssl_cipher_iv_length(self::$cipher);
        $iv = substr($data, 0, $iv_length);
        $encrypted = substr($data, $iv_length);

        // Verinin şifresini çöz.
        return openssl_decrypt($encrypted, self::$cipher, self::$secretKey, 0, $iv);
    }
}



