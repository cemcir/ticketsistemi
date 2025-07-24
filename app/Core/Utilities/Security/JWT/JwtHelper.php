<?php

namespace App\Core\Utilities\Security\JWT;

require_once "vendor/autoload.php";

use App\Core\Utilities\Results\ErrorDataResult;
use App\Core\Utilities\Results\IDataResult;
use App\Core\Utilities\Results\SuccessDataResult;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use PhpParser\Node\Expr\Cast\Object_;

class JwtHelper implements ITokenHelper
{
    private static $secretKey="phpfullstackdeveloperenescemcir";
    public static function CreateToken(array $user): string
    {
        return JWT::encode([
            'adminId'=>$user['adminId'],
            'role'=>$user['role'],
            'name'=>$user['name'],
            'surname'=>$user['surname'],
            'image'=>$user['image'],
            'iat'=>time(),
            'exp'=>time()+1500 // 25 dk lık Jwt Oluşturduk
        ],self::$secretKey,'HS256');
    }

    public static function ValidateToken(string $jwt):IDataResult
    {
        try {
            $decoded=JWT::decode($jwt,new Key(self::$secretKey,'HS256'));
            return new SuccessDataResult($decoded,'');
        }
        catch (ExpiredException $e) {
            return new ErrorDataResult([],'Token Süresi Dolmuş');
        }
        catch (\Exception $e) {
            return new ErrorDataResult([],'Geçersiz Kullanıcı');
        }
    }

}
