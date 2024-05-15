<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckLevel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (Auth::user()->level === 'admin') {
            return $next($request);
        } else {
            if (in_array(Auth::user()->level, $roles)) {
                return $next($request);
            } else {
                return redirect()->to('login', 302);
            }
        }
    }
}
