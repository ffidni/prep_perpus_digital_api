<?php

namespace App\Http\Middleware;

use App\Http\Resources\ApiResponse;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        try {
            $token = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof TokenInvalidException) {
                return new ApiResponse(Response::HTTP_UNAUTHORIZED, "Token Invalid", null);
            } else if ($e instanceof TokenExpiredException) {
                return new ApiResponse(Response::HTTP_UNAUTHORIZED, "Token Expired", null);
            } 
            return new ApiResponse(Response::HTTP_UNAUTHORIZED, "Authorization code tidak ditemukan", null);
        }
        return $next($request);
    }
}
