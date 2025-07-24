<?php

namespace App\Core\Utilities\Security\Hashing;

class HashingHelper
{
    public static function PasswordHash(string $password):string
    {
        return password_hash($password,PASSWORD_BCRYPT);
    }

    public static function PasswordVerify(string $password,string $hashedPassword):bool
    {
        if(password_verify($password,$hashedPassword)) {
            return true;
        }
        return false;
    }

}
