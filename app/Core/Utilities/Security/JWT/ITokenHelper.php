<?php

namespace App\Core\Utilities\Security\JWT;

use App\Core\Utilities\Results\IDataResult;

interface ITokenHelper
{
    public static function CreateToken(array $user):string; // Token Üretecek Method
    public static function ValidateToken(string $jwt):IDataResult; // Token Doğrulayacak Method
}
