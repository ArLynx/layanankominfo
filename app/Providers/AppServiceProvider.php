<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        View::composer('*', function ($view) {
            if (!Auth::check()) {
                return;
            }

            $headerNotifications = Notification::where('recipient_type', Auth::user()->role)
                ->where('recipient_id', Auth::id())
                ->latest()
                ->take(5)
                ->get();

            $unreadNotifications = Notification::where('recipient_type', Auth::user()->role)
                ->where('recipient_id', Auth::id())
                ->where('is_read', false)
                ->count();

            $view->with([
                'headerNotifications' => $headerNotifications,
                'unreadNotifications' => $unreadNotifications,
            ]);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Carbon::setLocale('id');
    }
}
