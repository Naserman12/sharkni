<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            app()->setLocale(Auth::user()->language);
        }elseif ($request->has('language')) {
            app()->setLocale($request->input('language'));
            session(['language' => $request->input('language')]);
        }elseif (session('language')) {
            app()->setLocale(session('language'));
        }else{
            app()->setLocale('en');
        }
        return $next($request);
    }
}
