<?php 
namespace App\Http\Middleware;
 
use Closure;
 
class AuthSalon
{
    public function handle($request, Closure $next)
    {
        if (auth()->user()->tokenCan('role:salon')) {
            return $next($request);
        }
        return response()->json('Not Authorized', 401);
    }
}