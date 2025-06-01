<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * قائمة الأحداث (Events) والمستمعين (Listeners).
     *
     * @var array
     */
    protected $listen = [
        // مثال:
        // 'App\Events\SomeEvent' => [
        //     'App\Listeners\EventListener',
        // ],
    ];

    /**
     * تسجيل أي أحداث إضافية للتطبيق.
     */
    public function boot(): void
    {
        //
    }
}
