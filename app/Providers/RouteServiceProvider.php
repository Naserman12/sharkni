<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * المسار إلى "صفحة البداية" لتطبيقك.
     *
     * عادةً ما يتم إعادة التوجيه إليه بعد تسجيل الدخول.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * تسجيل أي خدمات روت.
     */
    public function boot(): void
    {
        $this->routes(function () {
            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            
        });
    }
}
