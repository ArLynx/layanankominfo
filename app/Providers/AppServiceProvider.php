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
            $user = Auth::user() ?? Auth::guard('admin')->user();

            if (!$user) {
                return;
            }

            $headerNotifications = Notification::where('recipient_type', $user->role)
                ->where('recipient_id', $user->id)
                ->latest()
                ->take(5)
                ->get();

            $unreadNotifications = Notification::where('recipient_type', $user->role)
                ->where('recipient_id', $user->id)
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
