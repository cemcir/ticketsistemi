<?php

namespace App\Http\Middleware\ValidateRequest;

use App\Business\Validation\Keys;
use App\Business\Validation\ValidationRules;
use App\Core\Utilities\Business\BusinessHelper;
use App\Core\Validation\ValidationHelper;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateCategoryAdd
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request,Closure $next): Response
    {
        $result = ValidationHelper::Run($request,Keys::CategoryAdd(),ValidationRules::CategoryAddValidator());
        if($result!=null) {
            return $result;
        }
        return $next($request);
    }
}
