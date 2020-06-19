<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Namshi\JOSE\JWT;
//use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Support\Utils;

class CheckToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $token = JWTAuth::getToken();
            $payload = JWTAuth::getpayload($token);
        }
        catch (TokenExpiredException $e)
        {
            return response("Token has expired! Please login again...", 403);
        }
        catch (JWTException $e)
        {
            return response("Unauthenticated", 403);
        }
        return $next($request);
    }
}
