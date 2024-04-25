<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class Authenticate
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
        error_log('Handling request: ' . $request->path());

        try {
            $user = JWTAuth::parseToken()->authenticate();
            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }
        } catch (TokenExpiredException $e) {
            error_log('JWT Error: ' . $e->getMessage());
            return response()->json(['error' => 'Token has expired'], 401);
        } catch (TokenInvalidException $e) {
            error_log('JWT Error: ' . $e->getMessage());
            return response()->json(['error' => 'Token is invalid'], 401);
        } catch (JWTException $e) {
            error_log('JWT Error: ' . $e->getMessage());
            return response()->json(['error' => 'Token is absent'], 401);
        } catch (\Exception $e) {
            error_log('General Error: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred'], 500);
        }

        return $next($request);
    }
}
