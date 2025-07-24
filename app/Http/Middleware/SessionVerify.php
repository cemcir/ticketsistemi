<?php

namespace App\Http\Middleware;

use App\Core\Utilities\Security\JWT\JwtHelper;
use Closure;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SessionVerify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request,Closure $next,...$roles):Response
    {

        if(Session::has('token')) {

            $result=JwtHelper::ValidateToken(Session::get('token'));
            if($result->Status()) {
                $dizi = json_decode(json_encode($result->Data()), true);
                if(!in_array($dizi['role'],$roles)) {
                    return $this->SessionDestroy();
                }
                $request->attributes->add(['admin'=>(array) $result->Data()]);
            }
            else {
                return $this->SessionDestroy();
            }
        }
        else {
            return $this->SessionDestroy();
        }
        session()->regenerate();

        return $next($request);

        /*

        if(session()->has('token')) {
            $response = Http::withToken(session('token'))
                            ->get('https://ikysapi.samsun.bel.tr/api/User/UserCheck');

            // Gelen yanıtı kontrol et
            if ($response->ok()) {
                return $next($request);
            }
        }

        return $this->SessionDestroy();
        */
    }

    private function SessionDestroy() {

        Auth::logout(); // Oturumu sonlandır
        session()->invalidate(); // Tüm oturumları sıfırla
        session()->regenerateToken(); // CSRF token'ını yenile
        session()->flush(); // Oturum verilerini temizle
        session()->regenerate(); // Yeni bir oturum başlat (ID yenile)

        return redirect()->route('loginForm');

    }

}
