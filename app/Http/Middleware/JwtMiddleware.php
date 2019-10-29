<?php

namespace App\Http\Middleware;

use App\Libraries\APIResponse;
use Closure;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware extends BaseMiddleware
{
    use APIResponse;

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return $this->sendResponse(401, null, ['status' => 'Token is invalid'], 481);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return $this->sendResponse(401, null, ['status' => 'Token is expired'], 480);
            } else {
                return $this->sendResponse(401, null, ['status' => 'Authorization Token not found'], 482);
            }
        }
        return $next($request);
    }
}
