<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

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

            $notifications = Notification::where('recipient_type', Auth::user()->role)
                ->where('recipient_id', Auth::id())
                ->latest()
                ->take(5)
                ->get();

            $unreadNotifications = Notification::where('recipient_type', Auth::user()->role)
                ->where('recipient_id', Auth::id())
                ->where('is_read', false)
                ->count();

            $view->with([
                'notifications' => $notifications,
                'unreadNotifications' => $unreadNotifications,
            ]);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {}
}
