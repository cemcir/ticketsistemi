<?php

namespace App\Http\Middleware;

use App\Core\Utilities\Security\JWT\JwtHelper;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JwtVerify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $token=$request->header('Authorization');
        $jwt=explode(' ',$token);

        if(!isset($jwt[0]) || !isset($jwt[1])) {
            return response()->json(['status'=>400,'msg'=>'Geçersiz Kullanıcı']);
        }

        $result=JwtHelper::ValidateToken($jwt[1]);
        if(!$result->Status()) {
            return response()->json(['status'=>400,'msg'=>$result->Message()],400);
        }
        $request->attributes->add(['user'=>(array) $result->Data()]);

        if(!in_array($result->Data()->role,$roles)) {
            return response()->json(['status'=>403,'msg'=>'İşlem İçin Yetkiniz Bulunmamaktadır']);
        }

        return $next($request);
    }
}
