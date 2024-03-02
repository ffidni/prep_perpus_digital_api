<?php

namespace App\Http\Middleware;

use App\Exceptions\ApiException;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminLibrarianMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if ($user && ($user->user_type == 'admin' || $user->user_type == 'librarian')) {
            return $next($request);
        }

        throw new ApiException(Response::HTTP_FORBIDDEN, "Anda bukan admin atau librarian!", null);
    }
}