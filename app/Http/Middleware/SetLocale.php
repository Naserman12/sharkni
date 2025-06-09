<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
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
        //  if ($request->hasHeader('Accept-language')) {
        //     App::setLocale($request->header('Accept-language'));
        // }
        // if ($request->Session::has('language')) {
        //     App()->setLocale(Session::get('language'));
        // }
        if (Auth::check()) {
            $language = Auth::user()->language ?? App()->setLocale(session()->get('language'));
            app()->setLocale($language);
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
