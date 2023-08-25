<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

use App\Http\Responses\ApiError;

class JwtVerify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['error' => 'User associated with this token was not found.'], 404);
            }
        } catch (TokenExpiredException $e) {
            return ApiError::invalidToken('Your session has expired. Please log in again.');
        } catch (TokenInvalidException $e) {
            return ApiError::unauthorized('Provided token is invalid.');
        } catch (JWTException $e) {
            return ApiError::badRequest('Token is required but was not provided.');
        }

        $request->merge(['authUser' => $user]);
    
        return $next($request);
    }
}
