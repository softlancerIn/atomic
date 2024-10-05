<?php 
namespace App\Http\Middleware;
 
use Closure;
 
class AuthCustomer
{
    public function handle($request, Closure $next)
    {
        if (auth()->user()->tokenCan('role:customer')) {
            return $next($request);
        }
        return response()->json('Not Authorized', 401);
    }
}