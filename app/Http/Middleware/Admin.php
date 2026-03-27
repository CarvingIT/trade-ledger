<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!$request->user() || (!$request->user()->hasRole('admin'))){

            // Needs more work. Redirect user to a page that shows permission-denied message
            return redirect('/login');
        }

        return $next($request);
    }
}
