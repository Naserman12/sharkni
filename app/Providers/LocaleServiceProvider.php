<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LocaleServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // تحديد اللغة الحالية
        $locale = 'en'; // لغة افتراضية

        if (Auth::check()) {
            // لو المستخدم مسجل دخول، خذ اللغة من ملفه
            $locale = Auth::user()->language ?? 'en';
        } elseif (Session::has('locale')) {
            // لو فيه جلسة محفوظة مسبقًا
            $locale = Session::get('locale');
        }

        // تخزينها في الجلسة وتطبيقها
        App::setLocale($locale);
        Session::put('locale', $locale);
    }
}
