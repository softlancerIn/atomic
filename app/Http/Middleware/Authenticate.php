<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */




    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            $uri = $request->path();
            $prefix = explode("/", $uri)[0];

            if (($prefix == 'admin')) {
                return route('admin.login');
            }
            if ($prefix == 'vendor') {
                return route('vendor.login');
                // return redirect('/vendors/login');
            }
        }
        /* else{
            $role = auth()->user()->role;
            $uri = $request->path();
            $prefix = explode("/", $uri)[0];
            if (($prefix == 'admin') && ($role != 1)) {
                return route('login');
            } else if (($prefix == 'admin') && ($role != 1)) {
                return route('login');
            }
        } */
    }
}
